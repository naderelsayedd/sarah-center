<?php
	
	namespace Modules\Chat\Http\Controllers;
	
	use App\Models\User;
	use App\Traits\ImageStore;
	use Brian2694\Toastr\Facades\Toastr;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Controller;
	use Illuminate\Support\Facades\DB;
	use Modules\Chat\Entities\Conversation;
	use App\Events\ChatEvent;
	use Modules\Chat\Entities\Group;
	use Modules\Chat\Entities\Notification;
	use Modules\Chat\Notifications\MessageNotification;
	use Modules\Chat\Services\ConversationService;
	use Modules\Chat\Services\GroupService;
	use Modules\Chat\Services\InvitationService;
	use Illuminate\Contracts\Support\Renderable;
	use PhpParser\Node\Stmt\DeclareDeclare;
	
	class ChatController extends Controller
	{
		use ImageStore;
		
		public $invitationService, $groupService, $conversationService;
		
		public function __construct(InvitationService $invitationService, GroupService $groupService, ConversationService $conversationService)
		{
			$this->invitationService = $invitationService;
			$this->groupService = $groupService;
			$this->conversationService = $conversationService;
		}
		
		public function index($id=null, $notification_id=null)
		{
			try {
				$users = $this->invitationService->getAllConnectedUsers();
				if ($id){
					$activeUser = $users->where('id',$id)->first();
					
					$notification = auth()->user()->notifications()->find($notification_id) ?? null;
					if ($notification_id && $notification){
						$notification->markAsRead();
					}
					}else{
					$activeUser = $users->last();
				}
				
				if ($users->isEmpty()){
					$activeUser = null;
					$messages = [];
					}else{
					$this->conversationService->readAllNotification($activeUser);
					$messages = auth()->user()->userSpecificConversation($activeUser->id);
					if (in_array($activeUser->id,$this->invitationService->getBlockUsers())){
						$activeUser->blocked = true;
						}else{
						$activeUser->blocked = false;
					}
				}
				
				$groups = $this->groupService->getAllGroup();
				return view('chat::index', compact('users','activeUser','messages','groups'));
				}catch (\Exception $exception){
				Toastr::error('Something happened Wrong!', 'Error!!');
				return redirect()->back();
			}
		}
		
		public function create()
		{
			return view('chat::create');
		}
		
		public function store(Request $request)
		{

			$limit = ((int) app('general_settings')->get('chat_file_limit')*1024) ?? 204800;
			$validation = \Validator::make($request->all(), [
	            'message' => 'sometimes',
	            'from_id' => 'required',
	            'to_id' => 'required',
	            'file_attach' => 'max:'.$limit
			]);
			
			if ($validation->fails()){
				Toastr::error($validation->messages());
				return redirect()->back();
			}
			
			if ($request->message == null && $request->file_attach == 'null'){
				return response()->json([
                'empty' => true
				]);
			}
			// if($request->message == 'null'){
			// 	return response()->json([
            //     'empty' => true
			// 	]);
			// }
			
			list($img_name, $original_name, $type) = $this->fileHandle($request);
			
			$this->replyValidation($request);
			
			$message = Conversation::create([
	            'from_id' => auth()->id(),
	            'to_id' => $request->to_id,
	            'message' => $request->message,
	            'file_name' => $img_name,
	            'original_file_name' => $original_name,
	            'message_type' => $type,
	            'reply' => $request->reply,
			])->load('reply','forwardFrom');


			User::find($request->to_id)->notify(new MessageNotification($message));
			broadcast(new ChatEvent($message))->toOthers();
			
			return ['status' => 'success','message' => $message];
		}
		
		public function show($id)
		{
			$users = $this->invitationService->getAllConnectedUsers();
			$activeUser = User::with('ownConversations','oppositeConversations','activeStatus')->find($id);
			$messages = auth()->user()->userSpecificConversation($activeUser->id);
			
			return view('chat::show', compact('users','activeUser','messages'));
		}
		
		public function edit($id)
		{
			return view('chat::edit');
		}
		
		public function update(Request $request, $id)
		{
			//
		}
		
		public function destroy(Request $request)
		{
			$validation = \Validator::make($request->all(), [
            'user_id' => 'required',
            'conversation_id' => 'required',
			]);
			
			if ($validation->fails()){
				return response()->json([
                'success' => false,
                'message' => $validation->messages()
				]);
			}
			
			try {
				if ($this->conversationService->oneToOneDelete($request->all())){
					return response()->json([
                    'success' => true
					]);
				}
				}catch (\Exception $e){
				return response()->json([
                'success' => false,
                'message' => $e->getMessage()
				]);
			}
		}
		
		public function download($id)
		{
			$conversation = Conversation::find($id);
			if (!in_array(auth()->id(),[$conversation->to_id, $conversation->from_id])){
				Toastr::error('Something happened Wrong!', 'Error!!');
				return redirect()->back();
			}
			
			return response()->download(base_path($conversation->file_name));
		}
		
		public function files($type, $id)
		{
			$groups = $this->groupService->getAllGroup();
			$users = $this->invitationService->getAllConnectedUsers();
			$group = null;
			
			if ($type == 'single'){
				$user = User::find($id);
				$name = $user->first_name. " ". $user->last_name;
				$messages = auth()->user()->userSpecificConversationCollection($id)->where('message_type', '<>',0);
				}else{
				$group = Group::where('id', $id)->first();
				$messages = collect();
				$group->load('threads.conversation');
				foreach ($group->threads as $message){
					if ($message->conversation->message_type != 0){
						$messages->push($message->conversation);
					}
				}
				$name = $group->name;
			}
			
			
			return view('chat::files', compact('groups', 'users', 'messages', 'name','type', 'group'));
		}
		
		public function newMessageCheck (Request $request)
		{
			$validation = \Validator::make($request->all(), [
            'user_id' => 'required',
            'last_conversation_id' => 'required',
			]);
			$from_user = User::findOrFail($request->user_id);
			
			if ($validation->fails() || !$from_user->activeConnectionWithLoggedInUser()){
				return response()->json([
                'invalid' => true,
				]);
			}
			
			$messages = auth()->user()->userSpecificConversationCollection($from_user->id)
            ->where('id', '>', $request->last_conversation_id);
			
			return response()->json([
            'invalid' => false,
            'messages' => $messages
			]);
		}
		
		public function newNotificationCheck(Request $request)
		{
			$validation = \Validator::make($request->all(), [
            'notification_ids' => 'required',
			]);
			if ($validation->fails()){
				return response()->json([
                'invalid' => true,
				]);
			}
			(array) $array = json_decode($request->notification_ids);
			
			
			$notifications = DB::table('notifications')->where('notifiable_id', auth()->id())
			->whereNotIn('id', $array)
			->where('read_at', null)
			->get();
			
			foreach ($notifications as $notification){
				$notification->data = json_decode($notification->data);
			}
			
			return response()->json([
            'notifications' => $notifications
			]);
		}
		
		public function allRead(){
			$notifications = DB::table('notifications')->where('notifiable_id', auth()->id())
            ->where('read_at', null)
            ->get();
			
			foreach ($notifications as $notification){
				Notification::find($notification->id)->update([
                'read_at' => now()
				]);
			}
			
			Toastr::success('Notifications marked as read!','Success');
			return redirect()->back();
		}
		
		public function forward(Request $request)
		{
			
			$validation = \Validator::make($request->all(), [
			//            'message' => 'required',
            'from_id' => 'required',
            'to_id' => 'required',
			]);
			
			if ($validation->fails()){
				Toastr::error($validation->messages());
				return response()->json([
                'code'      =>  404,
                'message'   =>  'Error'
				], 404);
			}
			
			$message = Conversation::create([
	            'from_id' => $request->from_id,
	            'to_id' => $request->to_id,
	            'message' => $request->message ?? 'This is a forwarded message.',
	            'file_name' => $request->file_name,
	            'original_file_name' => $request->original_file_name,
	            'message_type' => 0,
	            'forward' => $request->forward,
	            'reply' => 0,
			])->load('reply','forwardFrom');
			
			User::find($request->to_id)->notify(new MessageNotification($message));
			broadcast(new ChatEvent($message))->toOthers();
			
			return ['status' => 'success','message' => $message];
		}
		
		public function fileHandle(Request $request): array
		{
			$img_name = null;
			$original_name = null;
			$type = 0;
			
			if ($request->hasFile('file_attach')) {
				$extension = $request->file('file_attach')->extension();
				if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
					$img_name = ImageStore::saveImage($request->file('file_attach'));
					} else {
					$img_name = ImageStore::saveFile($request->file('file_attach'));
				}
				$original_name = $request->file('file_attach')->getClientOriginalName();
				
				if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
					$type = 1;
					} elseif ($extension == 'pdf') {
					$type = 2;
					} elseif ($extension == 'doc' || $extension == 'docx') {
					$type = 3;
					} elseif ($extension == 'webm' || $extension == 'oga' || $extension == 'ogg') {
					$type = 4;
					} elseif (in_array($extension, ['mp4', '3gp', 'mkv'])) {
					$type = 5;
					} else {
					$type = 0;
				}
			}
			return array($img_name, $original_name, $type);
		}
		
		public function replyValidation(Request $request): void
		{
			if ($request->reply && ($request->reply == 'null' || $request->reply == null)) {
				$request->reply = null;
				} else {
				$request->reply = (int)$request->reply;
			}
		}
		
		public function new()
		{
			// $users = $this->invitationService->getAllConnectedUsers();
			// $groups = $this->groupService->getAllGroup();

			$groups = $this->groupService->getAllGroup()->map(function ($group) {
			    return [
			        'id' => $group->id,
			        'image_url' => $group->image_url,
			        'name' => $group->name,
			        'last_message' => $group->last_message,
			        'last_message_date' => $group->last_message_date,
			        'type' => 'group',
			    ];
			});

			$users = $this->invitationService->getAllConnectedUsers()->map(function ($user) {
			    return [
			        'id' => $user->id,
			        'avatar_url' => $user->avatar_url,
			        'full_name' => $user->full_name,
			        'last_message' => $user->last_message,
			        'last_message_date' => $user->last_message_date,
			        'type' => 'user',
			        'unread' => $user->unread_chats
			    ];
			});

			// pr($groups);

			if ($groups->isNotEmpty()) {
			    $combined = $groups->merge($users);
			    $users = $combined->sortByDesc('last_message_date')->values();
			} else {
			    $users = collect($users)->sortByDesc('last_message_date')->values();
			}
			// $combined = $groups->merge($users);
			// $users = $combined->sortByDesc('last_message_date')->values();
			return view('chat::new-chat', compact('users'));
		}
		
		public function mininew()
		{

			return $users = $this->invitationService->getAllConnectedUsers()->map(function ($user) {
			    return [
			        'id' => $user->id,
			        'avatar_url' => $user->avatar_url,
			        'full_name' => $user->full_name,
			        'last_message' => $user->last_message,
			        'last_message_date' => $user->last_message_date,
			        'type' => 'user',
			        'unread' => $user->unread_chats
			    ];
			});


		}

		public function loadMore(Request $request)
		{
			$validation = \Validator::make($request->all(), [
            'ids' => 'required',
            'user_id' => 'required',
			]);
			
			if ($validation->fails()){
				return response()->json([
                'success' => false
				]);
			}
			
			$messages = auth()->user()->userSpecificConversationForLoadMore($request->user_id, $request->ids);
			
			if ($messages->isEmpty()){
				$messages = null;
			}
			return response()->json([
            'success' => true,
            'conversations' => $messages
			]);
			
		}
		
		public function chatSearch(Request $request)
		{
			try {
				return SmStudent::when(is_string($request->search), function ($q) use ($request) {
					$q->where('full_name', 'like', '%' . $request->search . '%')->orWhere('national_id_no', 'like', '%' . $request->search . '%');
				})->get()
				->map(function ($value) {
					return [
					'name' => $value->full_name,
					'route' => route('student_view', $value->id),
					// student_view
					];
				});
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}

		public function userSearchAjax(Request $request)
		{
			$validation = \Validator::make($request->all(), [
            	'keywords' => 'required',
			]);
			
			if ($validation->fails()){
				return [
					'message' => 'keywords required.',
					'error' => true,
					];
			}
			
			$keywords = $request->keywords;
			$group = [];
			$users = User::where('full_name', 'like', '%' . $request->keywords . '%')->orWhere('email', 'like', '%' . $request->keywords . '%')->with([
				        'ownConversations' => function($query) {
				            $query->latest();
				        },
				        'oppositeConversations' => function($query) {
				            $query->latest();
				        },
				        'activeStatus',
				    ])->get();
			if ($users->count() == 0) {
				$group = Group::where('name','like','%'.$request->keywords.'%')->get();
				
			}
			$result = array('type' => '','users' => '','groups' => '');
			if ($users->count() > 0) {
				$result['type'] = 'user';
				$result['users'] = $users;
				$result['groups'] = null;
				return $result;
			}else if($group->count() > 0){
				$result['type'] = 'group';
				$result['groups'] = $group;
				$result['users'] = null;
				return $result;
			}else{
				return false;
			}

		}


		public function userMessagesAjax(Request $request)
		{

			$user = User::with([
			    'ownConversations' => function ($query) use ($request) {
			        $query->where('to_id', auth()->user()->id);
			        $query->where('from_id', $request->user_id);
			        $query->select('*', DB::raw("'left' as side"));
			    },
			    'oppositeConversations' => function ($query) use ($request){
			        $query->addSelect(DB::raw("'right' as side"));
			        $query->where('to_id', $request->user_id);
			        $query->select('*', DB::raw("'right' as side"));
			    },
			    'activeStatus',
			])->find($request->user_id);
			$users = $user? $user->toArray() : [];


			if (empty($users)) {
				return false;
			}else{

				/*seen all the messages*/
				if (isset($request->seen) == 'seen') {
					Conversation::where([
						'to_id' => auth()->user()->id,
						'from_id' => $request->user_id
					])->update(['status' => 1]);
				}

				$combinedConversations = array_merge($users['own_conversations'], $users['opposite_conversations']);			
				usort($combinedConversations, function($a, $b) {
				    return   $a['id'] - $b['id'];
				});
				$lastChat['message'] = '';
				$lastChat['time'] = '';
				$unread = 0;
				$chatHtml = '<ul>';
				foreach ($combinedConversations as $key => $value) {
					$date = new \DateTime($value['created_at']); $class = 'massg-recieved';
					if ($value['side'] == 'right') {
						$class = 'massg-sent';
					}
					$attachment = '';
					if ($value['message_type'] == 1) {
					    $attachment = '<img class="attachment-image" src="' . asset($value['file_name']) . '" style="width: 250px;">';
					} else if ($value['message_type'] !== 0 && $value['message_type'] !== 1) {
					    $attachment = '<a href="' . asset($value['file_name']) . '" target="_blank" style="color: #ffffff;font-size:15px;"><i class="fas fa-file"></i> Attachment (Document)</a>';
					}
					$chatHtml .= '<li class="mssg ' . $class . '">
	                  <div class="mssg-content">
	                   ' . $attachment . '
	                     <p>' . $value["message"] . '</p>
	                     <div class="mssge-info">' . $date->format("d-m-Y h:i A") . '</div>
	                  </div>
	                </li>';
	                if ($value['status'] == 0) {
	                	$unread = $unread + 1;
	                }
	               	$lastChat['message'] = $value["message"];
					$lastChat['time'] = $date->format("d-m-Y h:i A");
				}
				$chatHtml .= '</ul>';
				return array('users' => $users,'chatHtml' => $chatHtml,'last_chat' => $lastChat );
			}
		}


		public function groupMessagesAjax(Request $request)
		{
			$groupData = Group::where('id', $request->group_id)
		    ->with(['threads' => function ($query) {
		        $query->join('chat_conversations', 'chat_group_message_recipients.conversation_id', '=', 'chat_conversations.id');
		    }, 'threads.user']) // add this
		    ->first()->toArray();
		    if (count($groupData['threads']) > 0) {
			    $chatHtml = '<ul>'; 
				foreach ($groupData['threads'] as $key => $value) {
					$date = new \DateTime($value['created_at']); $class = 'massg-recieved';
					if ($value['user']['id'] == auth()->user()->id) {
						$class = 'massg-sent';
					}


					$attachment = '';
					if ($value['message_type'] == 1) {
					    $attachment = '<img class="attachment-image" src="' . asset($value['file_name']) . '" style="width: 250px;">';
					} else if ($value['message_type'] !== 0 && $value['message_type'] !== 1) {
					    $attachment = '<a href="' . asset($value['file_name']) . '" target="_blank" style="color: #ffffff;font-size:15px;"><i class="fas fa-file"></i> Attachment (Document)</a>';
					}

					$chatHtml .= '<li class="mssg '.$class.'">
	                  <div class="mssg-content">
	                  	 ' . $attachment . '
	                     <p>'.$value["message"].'</p>
	                     <span>By: '.$value['user']['full_name'].'</span>
	                     <div class="mssge-info">'.$date->format("d-m-Y h:i A").'</div>
	                  </div>
	               </li>';
				}
				$chatHtml .= '</ul>';
				/*get the last message of the chat and date time*/
				$lastChat['message'] = '';
				$lastChat['time'] = '';
				if (!empty($groupData['threads'])) {
					$latestConversation = $groupData['threads'][0];
					$date = new \DateTime($latestConversation['created_at']);
					$lastChat['message'] = $latestConversation['message'];
					$lastChat['time'] = $date->format("d-m-Y h:i A");
				}
				$result = array(
					'chatHtml' => $chatHtml, 
					'groupData' => $groupData,
					'last_chat' => $lastChat
				);
				return $result;
		    }else{
		    	$result = array(
					'chatHtml' => '', 
					'groupData' => $groupData,
					'last_chat' => ''
				);
				return $result;
		    }

		}


		public function searcgMessagesAjax(Request $request)
		{

			if ($request['searchFromId'] == 'user') {
				$searchQuery = $request->input('searchQuery');

			    $user = User::with([
			        'ownConversations' => function ($query) use ($request, $searchQuery) {
			            $query->where('to_id', auth()->user()->id);
			            $query->where('from_id', $request['searchInId']);
			            $query->where('message', 'like', '%'. $searchQuery. '%'); // add this line
			            $query->select('*', DB::raw("'left' as side"));
			        },
			        'oppositeConversations' => function ($query) use ($request, $searchQuery) {
			            $query->addSelect(DB::raw("'right' as side"));
			            $query->where('to_id', $request['searchInId']);
			            $query->where('message', 'like', '%'. $searchQuery. '%'); // add this line
			            $query->select('*', DB::raw("'right' as side"));
			        },
			        'activeStatus',
			    ])->find($request['searchInId']);

			    $users = $user? $user->toArray() : [];
			    $combinedConversations = array_merge($users['own_conversations'], $users['opposite_conversations']);			
				usort($combinedConversations, function($a, $b) {
				    return   $a['id'] - $b['id'];
				});

				$chatHtml = '<ul>';
				foreach ($combinedConversations as $key => $value) {
					$date = new \DateTime($value['created_at']); $class = 'massg-recieved';
					if ($value['side'] == 'right') {
						$class = 'massg-sent';
					}
					$attachment = '';
					if ($value['message_type'] == 1) {
					    $attachment = '<img class="attachment-image" src="' . asset($value['file_name']) . '" style="width: 250px;">';
					} else if ($value['message_type'] !== 0 && $value['message_type'] !== 1) {
					    $attachment = '<a href="' . asset($value['file_name']) . '" target="_blank" style="color: #ffffff;font-size:15px;"><i class="fas fa-file"></i> Attachment (Document)</a>';
					}
					$chatHtml .= '<li class="mssg ' . $class . '">
	                  <div class="mssg-content">
	                   ' . $attachment . '
	                     <p>' . $value["message"] . '</p>
	                     <div class="mssge-info">' . $date->format("d-m-Y h:i A") . '</div>
	                  </div>
	                </li>';
				}
				$chatHtml .= '</ul>';
				return $chatHtml;
			}


			if ($request['searchFromId'] == 'group') {
				$searchQuery = $request->input('searchQuery');

			    $groupData = Group::where('id', $request['searchInId'])
		        ->with(['threads' => function ($query) use ($searchQuery) {
		            $query->join('chat_conversations', 'chat_group_message_recipients.conversation_id', '=', 'chat_conversations.id')
		                   ->where('chat_conversations.message', 'like', '%'. $searchQuery. '%'); // add this line
		        }, 'threads.user']) 
		        ->first();

			    if (count($groupData['threads']) > 0) {
			        $chatHtml = '<ul>'; 
			        foreach ($groupData['threads'] as $key => $value) {
			            $date = new \DateTime($value['created_at']); 
			            $class = 'massg-recieved';
			            if ($value['user']['id'] == auth()->user()->id) {
			                $class = 'massg-sent';
			            }

			            $attachment = '';
			            if ($value['message_type'] == 1) {
			                $attachment = '<img class="attachment-image" src="' . asset($value['file_name']) . '" style="width: 250px;">';
			            } else if ($value['message_type'] !== 0 && $value['message_type'] !== 1) {
			                $attachment = '<a href="' . asset($value['file_name']) . '" target="_blank" style="color: #ffffff;font-size:15px;"><i class="fas fa-file"></i> Attachment (Document)</a>';
			            }

			            $chatHtml .= '<li class="mssg '.$class.'">
			                  <div class="mssg-content">
			                   ' . $attachment . '
			                     <p>'.$value["message"].'</p>
			                     <span>By: '.$value['user']['full_name'].'</span>
			                     <div class="mssge-info">'.$date->format("d-m-Y h:i A").'</div>
			                  </div>
			               </li>';
			        }
			        $chatHtml .= '</ul>';

			        return $chatHtml;
			    }
			}

		}

}
