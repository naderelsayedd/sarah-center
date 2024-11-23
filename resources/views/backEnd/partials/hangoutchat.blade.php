<style>
#chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
}

#chat-icon {
    width: 50px;
    height: 50px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

#user-list-footer {
    position: absolute;
    bottom: 70px;
    right: 0;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 220px;
    overflow-y: scroll;
    overflow-x: hidden;
}

#user-list-footer ul {
    list-style-type: none;
    padding: 10px;
    margin: 0;
}

#user-list-footer ul li {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

#user-list-footer ul li:last-child {
    border-bottom: none;
}
.avatar{
	width: 30px;
}
.close-icon {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 18px;
  cursor: pointer;
}
.chat-header {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #333;
    color: #fff;
}

.chat-header .close-icon {
    font-size: 18px;
    cursor: pointer;
}

.chat-header h5 {
    margin: 0;
    color: white;
}

.chat-body {
    padding: 1px;
}
.chat-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    background-color: #f0f0f0;
    border-top: 1px solid #ccc;
}

.chat-footer input[type="text"] {
    width: calc(100% - 60px);
    height: 30px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.chat-footer button {
    width: 50px;
    height: 30px;
    border: none;
    border-radius: 5px;
    background-color: #884ea0;;
    color: #fff;
    cursor: pointer;
}

.chat-footer button:hover {
    background-color: #884ea0;;
}
#chat-window {
    position: fixed;
    bottom: 20px;
    right: 0;
    width: 300px;
    height: 400px;
    background-color: #f0f0f0;
    z-index: 1;
    display:none;
}

#chat-window:focus-within {
    z-index: 1;
}
</style>

@inject('provider', 'Modules\Chat\Http\Controllers\ChatController')
<?php $userChatData = $provider->mininew(); ?>
<a href="javascript:void(0);">	
	<div id="chat-container">
	    <div id="chat-icon" onclick="toggleUserList()">
	        <span class="fas fa fa-weixin"></span>
	    </div>
	    <div id="user-list-footer" style="display:none;">
	        <div class="close-icon" onclick="toggleUserList()">×</div>
	        <ul>
	        	<?php foreach ($userChatData as $key => $value):?>
	        		<li>
	        			<a href="javascript:void(0);" onclick="startChat('{{$value['id']}}', '{{$value['full_name']}}')">
		        			<div>
						        <img class="avatar" src="{{asset($value['avatar_url'])}}">
						        {{$value['full_name']}}
		        			</div>
	        			</a>
		        	</li>
	        	<?php endforeach?>
	        </ul>
	    </div>
	    <div id="chat-window">
		    <div class="chat-header">
		        <div class="close-icon" onclick="closeChatWindow()">×</div>
		        <h5 id="chat-user-name"></h5>
		    </div>
		    <div class="chat-body" style="overflow-x: hidden;overflow-y: auto;height: 325px;padding-bottom: 20px;">
		        <div id="chat-messages">
		        	<div class="chat_loading" style="display: none;text-align: center;font-size: 40px;padding: 27%;">
		                <i class="fa fa-spinner fa-spin"></i>
		            </div>
		        </div>
		    </div>
		    <div class="chat-footer">
		        <input type="text" id="chat-input" placeholder="Type a message...">
		        <button id="send-chat-btn">Send</button>
		    </div>
		</div>
	</div>
</a>
<script>
var to_userId = '';
function toggleUserList() {
  $('#user-list-footer').toggle();
}
function closeChatWindow() {
  $('#chat-window').hide();
  $('#user-list-footer').hide();
  $('#chat-messages').html('');
  localStorage.removeItem('chatOpen');
  localStorage.removeItem('currentUserId');
  localStorage.removeItem('currentUserName');
}
function startChat(userId, userName) {
  localStorage.setItem('chatOpen', true);
  localStorage.setItem('currentUserId', userId);
  localStorage.setItem('currentUserName', userName);

  $('#user-list-footer').hide();
  $('#chat-window').show();
  $('.chat_loading').show();
  $('#chat-user-name').text(userName);
  loadChats(userId);
}

if (localStorage.getItem('chatOpen') === 'true') {
	const userId = localStorage.getItem('currentUserId');
	const userName = localStorage.getItem('currentUserName');
	startChat(userId, userName);
}


function loadChats(userId) {
	to_userId = userId;
	$.ajax({
	    type: 'post',
	    url: "{{route('chat.search.user.get-user-messages')}}",
	    data: { 
	      _token : '{{ csrf_token() }}',
	      user_id: userId
	    },
	    success: function(data) {
	    	$('.chat_loading').hide();
	      	$('#chat-messages').html('');
	      	$('#chat-messages').html(data.chatHtml);
	      	$('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
	    }
	});
}

$('#send-chat-btn').on('click', function() {
    var userId = to_userId;
    var message = $('#chat-input').val();
    var from_id = <?php echo auth()->user()->id; ?>
    // Make an AJAX request to send the chat message
    $.ajax({
      type: 'POST',
      url: "{{ route('chat.send') }}",
      data: { 
      		_token: '{{ csrf_token() }}',
      		message: message ,
      		to_id:userId,
      		from_id:from_id
      },
      success: function(data) {
        $('#chat-input').val('');
        loadChats(userId);
      }
    });
});
/*load chat in every 10 sec*/
if (to_userId != '') {
	setInterval(function() {
	    loadChats(to_userId);
	}, 10000);
}

</script>