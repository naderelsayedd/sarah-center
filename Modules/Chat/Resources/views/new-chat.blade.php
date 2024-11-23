@extends('backEnd.master')
@section('title')
@lang('chat::chat.new_chat')
@endsection
@section('mainContent')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<style type="text/css">
	.search-con {
	position: relative; /* Add this */
	}
	
	.suggestions-dropdown {
	position: absolute;
	top: 100%; /* Move the dropdown down */
	left: 0; /* Align with the left edge of the search box */
	width: 100%; /* Make the dropdown the same width as the search box */
	background-color: #fff;
	border: 1px solid #ddd;
	padding: 10px;
	display: none;
	}
	
	.suggestion {
	padding: 10px;
	border-bottom: 1px solid #ddd;
	}
	
	.suggestion img {
	width: 30px;
	height: 30px;
	border-radius: 50%;
	margin-right: 10px;
	}
	
	.suggestion span {
	font-size: 16px;
	font-weight: bold;
	}
	
	.loading {
	text-align: center;
	padding: 10px;
	}
	
	.loading i.fa-spinner {
	font-size: 24px;
	margin-right: 10px;
	}
	#chat-box{
    min-height: 419px;
	}
	.chat-time{
    display: inline-flex;
    width: max-content;
	}
</style>
<!-- for chat starts here-->
<link rel="stylesheet" href="{{ asset('public/backEnd/chat/call-styles.css') }}" type="text/css">
<div class="box_header">
	<div class="main-title">
		<h3 class="m-0">@lang('chat::chat.chat_list')</h3>
	</div>
</div>
<div class="chat-wrapper">
	<div class="names-side">
		<div class="profile-info">
			<div class="avatar-side">
				@if(Auth::user()->avatar)
                <img class="chat-avatar bg-styles" src="{{asset(Auth::user()->avatar)}}">
				@elseif(Auth::user()->avatar_url)
                <img class="chat-avatar bg-styles" src="{{asset(Auth::user()->avatar_url)}}">
				@else
                <img class="chat-avatar bg-styles" src="<?php echo url('/public/chat/images/spondon-icon.png'); ?>">
				@endif
			</div>
			<div class="chat-name-side">
				<div class="chat-name-mssg">
					<div class="employee-name">{{Auth::user()->full_name}}</div>
				</div>
				<div class="current-chat-actions">
					<div class="chat-settings">
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-vertical"></i></button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="{{route('chat.group.create')}}">Create Group</a></li>
								{{--<li><a class="dropdown-item" href="#">Another action</a></li>
								<li><a class="dropdown-item" href="#">Something else here</a></li>--}}
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="search-con">
			<div class="search-box">
				<form action="">
					<input type="text" id="userSearch" class="form-control" placeholder="Search">
					<button class="search-icon"><i class="fa fa-search"></i></button>
				</form>
				<div id="user-suggestions" class="suggestions-dropdown"></div>
				<div class="loading" style="display: none;">
					<i class="fa fa-spinner fa-spin"></i> Loading...
				</div>
			</div>
		</div>
		<div class="names-wrapper my-custom-scroll">
            <div id="user-list"></div>
            @forelse($users as $user)
			<?php if (!empty($user['last_message']) && !empty($user['last_message_date'])): ?>
			<?php if($user['type'] == 'user'){ ?>
				<a href="javascript:void(0)" onclick="getUserMessages({{$user['id']}},false,'seen')">
					<?php }else if($user['type'] == 'group'){?>
					<a href="javascript:void(0);" onclick="getGroupMessages('{{$user['id']}}', false);">
					<?php } ?>
					<div class="chat-name-box">
						<div class="avatar-side">
							@if(isset($user['image_url']) || isset($user['avatar_url'] ))
							<img class="chat-avatar bg-styles" src="{{ asset($user['image_url']?? $user['avatar_url']) }}" alt="">
							@else
							<img class="chat-avatar bg-styles" src="{{ asset('public/chat/images/spondon-icon.png') }}">
							@endif
						</div>
						<div class="chat-name-side">
							<div class="chat-name-mssg">
								<div class="employee-name">{{ $user['name']?? $user['full_name'] }}</div>
								<div class="last-mssg">
									<p>{!! $user['last_message'] !!}</p>
								</div>
							</div>
							<div class="chat-details">
								<div class="chat-time">{{ $user['last_message_date'] }}</div>
								<?php if (isset($user['unread']) && $user['unread'] > 0): ?>
								<div class="unread-messages"><span class="mssgs-count">{{ $user['unread']??'' }}</span></div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</a>
                <?php endif ?>
				@empty
                <p>@lang('chat::chat.no_user_found_to_chat')!</p>
				@endforelse
			</div>
		</div>
		<div class="chat-side">
			<div class="chats">
				<div class="chat-header">
					<div class="chat-name">
						<div class="header-avatar bg-styles" style="background-image:url(images/profile-pic2.jpg);"></div>
						<div class="sender-name-status">
							<div class="name" id="SenderName">-</div>
							<div class="online-status"><small></small></div>
						</div>
					</div>
					<div class="chat-actions">
						<div class="open-search" style="display:none;"><i class="fa fa-magnifying-glass"></i></div>
						<div class="chat-settings-for-group">
							<div class="dropdown">
								<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-vertical"></i></button>
								<ul class="dropdown-menu">
									<form action="{{route('chat.group.leave')}}" method="post">
										@csrf
										<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
										<input id="leaveGroupId" type="hidden" name="group_id" value="">
										<li>
											<button type="submit" class="dropdown-item" href="#">Leave Group</button>
										</li>
										<li></li>
									</form>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class=" chat-window">
					<div class="chat-box my-custom-scroll" id="chat-box">
						<!-- chat html goes here -->
						<i class="fa fa-comments" style="font-size: 160px;padding: 16% 30%;"></i>
						<div class="chat_loading" style="display: none;text-align: center;font-size: 40px;padding: 27%;">
							<i class="fa fa-spinner fa-spin"></i>
						</div>
					</div>
					<div class="chat-input" style="display:none;">
						<form class="d-flex" role="message" onsubmit="event.preventDefault()">
							<button class="file-upload-btn" type="button"><i class="fa fa-paperclip"></i></button>
							<input id="fileInput" type="file" style="display:none;">
							<input id="hiddenToUserId" type="hidden" name="to_userId" value="">
							<input id="hiddenToTypeId" type="hidden" name="type" value="user">
							<div id="file-name-container" style="background-color: white;border-radius: 10px;width: 60px;text-align: center;padding: 4px;">No File</div>
							<input id="csrf-token" type="hidden" value="{{ csrf_token() }}">
							<input id="user-id" type="hidden" value="{{ auth()->user()->id }}">
							<input id="message" class="form-control me-2" type="text" placeholder="Write your message" aria-label="Message" value="">
							<button onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
			<div class="search-side">
				<div class="search-header">
					<div class="close-search"><i class="fa fa-xmark"></i></div>
					<div class="search-box">
						<form onsubmit="event.preventDefault()">
							<input type="text" class="form-control" placeholder="Search" id="chatSearch">
							<input id="searchInId" type="hidden" name="id" value="">
							<input id="searchFromId" type="hidden" name="type" value="">
							<button onclick="searchMessage()"><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
				<div class="search-results">
					<div class="results-box my-custom-scroll">
						<!-- search from chat goes here -->
					</div>
				</div>
			</div>
			<!-- search side -->
		</div>
	</div>
	
	<script>
		if($('.mssgs-count').length > 0) {
			var spans = document.querySelectorAll(".mssgs-count");
			for (var i = 0; i < spans.length; i++) {
				if (Number(spans[i].innerHTML) > 9) {
					spans[i].innerHTML = "9+";
				}
			}
		}
		if($('.chat-box .mssg:last-child').length > 0) {
			document.querySelector('.chat-box .mssg:last-child').scrollIntoView({});
		}
		if($('.open-search').length > 0) {
			document.querySelector('.open-search').addEventListener('click', function() {
				document.querySelector('.search-side').classList.add('opened');
			});
		}
		if($('.close-search').length > 0) {
			document.querySelector('.close-search').addEventListener('click', function() {
				document.querySelector('.search-side').classList.remove('opened');
			});
		}
	</script>
	<!-- emoji starts here -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
	<script>
		$('#message').emojioneArea({
			pickerPosition:'top'
		});
	</script>
	
	
	<script>
		$(document).ready(function() {
		$('.chat-settings-for-group').hide();
		$('.chat-input').hide();
		var baseUrl = "{{ asset('/') }}";
		$('.search-icon').on('click', function(e) {
			e.preventDefault(); // Prevent the form from being submitted in the traditional way
			var searchQuery = $('#userSearch').val();
			$.ajax({
				type: 'post',
				url: '{{ route('chat.search.user.ajax') }}',
				data: { _token:'{{csrf_token()}}', keywords: searchQuery },
				beforeSend: function() {
					$('.loading').show();
					$('.chat-input').hide();
				},
				success: function(data) {
					var suggestionsHtml = '';
					if (data == false) {
						suggestionsHtml += 'No user found';
						$('#user-suggestions').html(suggestionsHtml).slideDown();
						// Hide the loading indicator
						$('.loading').hide();
						}else{
						
						if (data.type =='user') {
							$.each(data.users, function(index, user) {
								suggestionsHtml += '<a href="javascript:void(0);" onclick="getUserMessages('+user.id+',true);"><div class="suggestion">' + 
								'<div class="avatar-side">' + 
								(user.image? 
								'<img class="chat-avatar bg-styles" src="' + baseUrl + user.image + '">' : 
								(user.avatar_url? 
								'<img class="chat-avatar bg-styles" src="' + baseUrl + user.avatar_url + '">' : 
								'<img class="chat-avatar bg-styles" src="' + baseUrl + 'public/chat/images/spondon-icon.png">'
								)
								) + 
								'<span>' + user.full_name + '</span>' + 
								'</div>' + 
								'</div></a>';
							});
							$('#user-suggestions').html(suggestionsHtml).slideDown();
							// Hide the loading indicator
							$('.loading').hide();
							$('.chat-input').show();
							var suggestionsHtml = '';
						}
						
						if (data.type == 'group') {
							$.each(data.groups, function(index, group) {
								suggestionsHtml += '<a href="javascript:void(0);" onclick="getGroupMessages(\'' + group.id + '\', true);"><div class="suggestion">' + 
								'<div class="avatar-side">' + 
								(group.photo_url? 
								'<img class="chat-avatar bg-styles" src="' + baseUrl + group.photo_url + '">' : 
								'<img class="chat-avatar bg-styles" src="' + baseUrl + 'public/chat/images/spondon-icon.png">'
								)
								+ 
								'<span>' + group.name + '</span>' + 
								'</div>' + 
								'</div></a>';
							});
							$('#user-suggestions').html(suggestionsHtml).slideDown();
							// Hide the loading indicator
							$('.loading').hide();
							$('.chat-input').show();
							var suggestionsHtml = '';
						}
						
						
					}
				}
			});
		});
		
		// Hide the suggestions dropdown when clicking outside
		$(document).on('click', function(e) {
			if ($(e.target).closest('.search-con').length === 0) {
				$('#user-suggestions').slideUp();
			}
		});
	});
	
	if (localStorage.getItem('currentUserId') != '') {
		userId = localStorage.getItem('currentUserId');
		list = localStorage.getItem('currentlist');
		seen = localStorage.getItem('seen');
		getUserMessages(userId,list,seen);
	}
	
	if (localStorage.getItem('currentGroupId') != '') {
		groupId = localStorage.getItem('currentGroupId');
		list = localStorage.getItem('currentlist');
		getGroupMessages(groupId,list,seen);
	}
	
	function getUserMessages(userId,list,seen) {
		if (localStorage.getItem('currentUserId') != '') {
			localStorage.removeItem('currentUserId');
			localStorage.removeItem('currentlist');
			localStorage.removeItem('seen');
		}
		localStorage.setItem('currentUserId', userId);
		localStorage.setItem('currentlist', list);
		localStorage.setItem('seen', 'seen');
		
		console.log(localStorage.getItem('currentUserId'));
		$('.chat-settings-for-group').hide();
		var userListhtml='';
		var baseUrl = "{{ asset('/') }}";
		$('#chat-box').html('<div class="chat_loading" style="display: none;text-align: center;font-size: 40px;padding: 27%;"><i class="fa fa-spinner fa-spin"></i></div>');
		$('.chat_loading').show();
		$('.chat-input').hide();
		$('.unread-messages').hide();
		$.ajax({
			type: 'post',
			url: "{{ route('chat.search.user.get-user-messages') }}",
			data: { _token:'{{csrf_token()}}', user_id: userId,seen },
			success: function(data) {
				$('.chat_loading').hide();
				$('.open-search').show();
				$('#hiddenToTypeId').val('user');
				if (list == 1) {
					var userListHtml = '<a href="javascript:void(0)" onclick="getUserMessages('+userId+',false)">';
					userListHtml += '<div class="chat-name-box">';
					userListHtml += '<div class="avatar-side">';
					if (data.users.avatar) {
						userListHtml += '<img class="chat-avatar bg-styles" src="' + baseUrl + data.users.avatar + '">';
						} else if (data.users.avatar_url) {
						userListHtml += '<img class="chat-avatar bg-styles" src="' + baseUrl + data.users.avatar_url + '">';
						} else {
						userListHtml += '<img class="chat-avatar bg-styles" src="' + baseUrl + 'public/chat/images/spondon-icon.png">';
					}
					userListHtml += '</div>';
					userListHtml += '<div class="chat-name-side">';
					userListHtml += '<div class="chat-name-mssg">';
					userListHtml += '<div class="employee-name">' + data.users.full_name +'</div>';
					userListHtml += '<div class="last-mssg">';
					userListHtml += '<p>You: ' + data.last_chat.message + '</p>';
					userListHtml += '</div>';
					userListHtml += '</div>';
					userListHtml += '<div class="chat-details">';
					userListHtml += '<div class="chat-time">' + data.last_chat.time + '</div>';
					userListHtml += '<div class="unread-messages"><span class="mssgs-count">' + data.users.unread_messages + '</span></div>';
					userListHtml += '</div>';
					userListHtml += '</div></a>';
					$('#user-list').prepend(userListHtml);
				}
				$('.chat-input').show();
				if(data.users && data.users.id) {
				$('#hiddenToUserId').val(data.users.id);
				$('#searchInId').val(data.users.id);
				$('#SenderName').text(data.users.full_name);
				}
				$('#searchFromId').val('user');
				$('#user-suggestions').slideUp();
				$('#chat-box').html(data.chatHtml);
				
				$('#chat-box').animate({ scrollTop: $('#chat-box')[0].scrollHeight }, 0);
			}
		});
	}
	
	
	function getGroupMessages(groupId,list) {
		if (localStorage.getItem('currentGroupId') != '' ) {
			localStorage.removeItem('currentGroupId');
			localStorage.removeItem('currentlist');
		}
		
		localStorage.setItem('currentGroupId', groupId);
		localStorage.setItem('currentlist', list);
		
		$('#leaveGroupId').val(groupId);
		$('.chat-settings-for-group').show();
		var userListhtml='';
		var baseUrl = "{{ asset('/') }}";
		$('#chat-box').html('<div class="chat_loading" style="display: none;text-align: center;font-size: 40px;padding: 27%;"><i class="fa fa-spinner fa-spin"></i></div>');
		$('.chat_loading').show();
		$('.chat-input').hide();
		$('#hiddenToUserId').val(groupId);
		$.ajax({
			type: 'post',
			url: "{{ route('chat.search.group.get-group-messages') }}",
			data: { _token:'{{csrf_token()}}', group_id: groupId },
			success: function(data) {
				$('.open-search').show();
				$('#hiddenToTypeId').val('group');
				$('.chat_loading').hide();
				if (list == 1) {
					var userListHtml = '<a href="javascript:void(0);" onclick="getGroupMessages(\'' + groupId + '\', false);">';
					userListHtml += '<div class="chat-name-box">';
					userListHtml += '<div class="avatar-side">';
					if (data.groupData.photo_url != '') {
						userListHtml += '<img class="chat-avatar bg-styles" src="' + baseUrl + data.groupData.photo_url + '">';
						} else {
						userListHtml += '<img class="chat-avatar bg-styles" src="' + baseUrl + 'public/chat/images/spondon-icon.png">';
					}
					userListHtml += '</div>';
					userListHtml += '<div class="chat-name-side">';
					userListHtml += '<div class="chat-name-mssg">';
					userListHtml += '<div class="employee-name">' + data.groupData.name +'</div>';
					userListHtml += '<div class="last-mssg">';
					userListHtml += '<p>You: ' + data.last_chat.message + '</p>';
					userListHtml += '</div>';
					userListHtml += '</div>';
					userListHtml += '<div class="chat-details">';
					userListHtml += '<div class="chat-time">' + data.last_chat.time + '</div>';
					userListHtml += '<div class="unread-messages"><span class="mssgs-count">' + data.groupData.unread_messages + '</span></div>';
					userListHtml += '</div>';
					userListHtml += '</div>';
					$('#user-list').prepend(userListHtml);
				}
				$('.chat-input').show();
				$('#user-suggestions').slideUp();
				$('#SenderName').text(data.groupData.name);
				$('#searchInId').val(groupId);
				$('#searchFromId').val('group');
				$('#chat-box').html(data.chatHtml);
				$('#chat-box').animate({ scrollTop: $('#chat-box')[0].scrollHeight }, 0);
			}
		});
	}
	const fileUploadBtn = document.querySelector('.file-upload-btn');
	const fileInput = document.querySelector('#fileInput');
	const messageInput = document.querySelector('#message');
	let formData = null;
	
	fileUploadBtn.addEventListener('click', () => {
		fileInput.click();
	});
	
	fileInput.addEventListener('change', () => {
		const file = fileInput.files[0];
		formData = new FormData();
		formData.append('file', file);
		// Update the file name above the input message box
		const fileName = file.name;
		const fileNameContainer = document.getElementById('file-name-container');
		fileNameContainer.innerText = '1 File';
	});
	
	function sendMessage() {
		const toUser = document.getElementById('hiddenToUserId').value;
		const messageInputValue = document.getElementById('message').value;
		const to_type = document.getElementById('hiddenToTypeId').value;
		const csrfToken = document.getElementById('csrf-token').value;
		const userId = document.getElementById('user-id').value;
		var url = contentdata = '';
		if (to_type == 'user') {
			url = "{{route('chat.send')}}";
			} else if (to_type == 'group') {
			url = "{{route('chat.group.send')}}";
		}
		
		const formData = new FormData();
		formData.append('_token', csrfToken);
		formData.append('to_id', toUser);
		formData.append('message', messageInputValue);
		formData.append('from_id', userId);
		
		const fileInput = document.getElementById('fileInput');
		if (fileInput.files.length > 0) {
			formData.append('file_attach', fileInput.files[0]);
		} 
		
		$.ajax({
			type: 'post',
			url: url,
			contentType: false,
			processData: false,
			data: formData,
			success: function(response) {
				document.getElementById('fileInput').value = '';
				document.getElementById('file-name-container').innerText = 'No File';
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	}
	
	setInterval(function() {
		handleMessageSent($('#hiddenToUserId').val());
	}, 10000);
	
	// Function to handle message sent
	function handleMessageSent(toUser) {
		const to_type           = document.getElementById('hiddenToTypeId').value;
		url='';data = '';
		if (to_type == 'user') {
			url ="{{ route('chat.search.user.get-user-messages') }}";
			data = { _token:'{{csrf_token()}}', user_id: toUser,list:false,seen:'seen' };
			}else if(to_type == 'group'){
			url ="{{ route('chat.search.group.get-group-messages') }}";
			data = { _token:'{{csrf_token()}}', group_id: toUser,list:false,seen:'seen' };
		}
		$.ajax({
			type: 'post',
			url: url,
			data: data,
			success: function(data) {
				// $('#hiddenToUserId').val(toUser);
				$('#chat-box').html(data.chatHtml);
				$('#chat-box').animate({ scrollTop: $('#chat-box')[0].scrollHeight }, 0);
			}
		});
	}
	
	function searchMessage() {
		var searchQuery = document.getElementById('chatSearch').value;
		var searchInId = document.getElementById('searchInId').value;
		var searchFromId = document.getElementById('searchFromId').value;
		
		$.ajax({
			type: 'POST',
			url: "{{route('chat.search.get-search-messages')}}", // replace with your server-side endpoint
			data: {
				_token: '{{csrf_token()}}',
				searchQuery: searchQuery,
				searchInId: searchInId,
				searchFromId: searchFromId
			},
			beforeSend: function() {
				$('.results-box').html('<div class="loading"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
			},
			success: function(response) {
				$('.results-box').html('');
				document.getElementById('chatSearch').value = '';
				$('.results-box').append(response);
			}
		});
	}
	
	
	
	document.querySelector('.open-search').addEventListener('click', function() {
		document.querySelector('.search-side').classList.add('opened');
	});
	document.querySelector('.close-search').addEventListener('click', function() {
		$('.results-box').html('');
		document.getElementById('chatSearch').value = '';
		document.querySelector('.search-side').classList.remove('opened');
	});
	</script>
	@endsection
