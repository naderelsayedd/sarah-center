<!DOCTYPE html>
<html lang="en">
	
	<head>
		<!-- All Meta Tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="{{ asset(generalSetting()->favicon) }}" type="image/png" />
		<title>@lang('auth.login')</title>
		<meta name="_token" content="{!! csrf_token() !!}" />
		
		<!-- Fonts -->
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('public/theme/edulia/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('public/theme/edulia/css/fontawesome.all.min.css') }}">
		
		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('public/theme/edulia/css/style.css') }}">
		<style>
			.row_gap_24 {
            row-gap: 24px;
			}
			
			.row_gap_24 input.input-control-input {
            font-size: 12px;
			}
			
			.login_wrapper {
            width: 550px;
			}
			
			.text-danger.text-left {
            font-size: 14px;
			}
		</style>
	</head>
	
	<body>
		
		<section class="login">
			<div class="login_wrapper">
				<!-- login form start -->
				<div class="login_wrapper_login_content">
					<div class="login_wrapper_logo text-center"><img src="{{ asset(generalSetting()->logo) }}"
					alt=""></div>
					<div class="login_wrapper_content">
						<h4>@lang('auth.login_details')</h4>
						  @if(session()->has('message-success') != "")
                            @if(session()->has('message-success'))
                            <p class="text-success">{{session()->get('message-success')}}</p>
                            @endif
                        @endif
                        @if(session()->has('message-danger') != "")
                            @if(session()->has('message-danger'))
                            <p class="text-danger">{{session()->get('message-danger')}}</p>
                            @endif
                        @endif
						<form action="{{ route('login') }}" method='POST'>
							@csrf
							<input type="hidden" name="username" id="username-hidden">
							<div class="input-control">
								<label for="#" class="input-control-icon"><i class="fal fa-envelope"></i></label>
								<input type="email" name="email" class="input-control-input"
                                placeholder="@lang('auth.enter_email_address')" value="{{ old('email') }}">
							</div>
							@if ($errors->has('email'))
                            <span class="text-danger text-left mb-15" role="alert">
                                {{ $errors->first('email') }}
							</span>
							@endif
							<div class="input-control">
								<label for="#" class="input-control-icon"><i class="fal fa-lock-alt"></i></label>
								<input type="password" name='password' class="input-control-input"
                                placeholder='@lang('auth.enter_password')'>
								</div>
								@if ($errors->has('password'))
								<span class="text-danger text-left mb-15" role="alert">
                                {{ $errors->first('password') }}
							</span>
							@endif
							<div class="input-control d-flex">
								<label for="#" class="checkbox">
									<input type="checkbox" class="checkbox-input" name="remember" id="rememberMe"
                                    {{ old('remember') ? 'checked' : '' }}>
									<span class="checkbox-title">@lang('auth.remember_me')</span>
								</label>
								<a href="{{ route('recoveryPassord') }}" id='forget'>@lang('auth.forget_password')?</a>
							</div>
							<div class="input-control">
								<input type="submit" class='input-control-input' value="Sign In">
							</div>
							<div class="create_account text-center">
								<p>Create New account? <a href="{{ URL::to('/onsite-nursery') }}">Register Here</a></p>
								{{-- <p>Create New account? <a href="javascript:void()" id="myBtn">Register Here</a></p> --}}
							</div>
						</form>
					</div>
				</div>
				
				@if (config('app.app_sync'))
				<div class="row justify-content-center align-items-center">
					<div class="col-lg-6 col-md-8">
						<div class="grid__button__layout">
							
							@foreach ($users as $user)
							@if ($user)
							<form method="POST" class="loginForm" action="{{ route('login') }}">
								@csrf()
								<input type="hidden" name="email" value="{{ $user[0]->email }}">
								<input type="hidden" name="auto_login" value="true">
								{{-- <button type="submit"
                                class="primary-btn fix-gr-bg  mt-10 text-center col-lg-12 text-nowrap">{{ $user[0]->roles->name }}</button> --}}
							</form>
							@endif
							@endforeach
						</div>
					</div>
				</div>
				@endif
				<!-- login form end -->
				@if (config('app.app_sync'))
                <div class="row justify-content-center align-items-center mt-20">
                    <div class="col-lg-12">
                        <div class="row row_gap_24">
                            @foreach ($users as $user)
							@if ($user)
							<div class="col-md-3">
								<form method="POST" class="loginForm" action="{{ route('login') }}">
									@csrf()
									<input type="hidden" name="email" value="{{ $user[0]->email }}">
									<input type="hidden" name="auto_login" value="true">
									<input type="submit" class='input-control-input'
									value="{{ $user[0]->roles->name }}">
								</form>
							</div>
							@endif
                            @endforeach
						</div>
					</div>
				</div>
				@endif
			</div>

			<!-- Start Animation -->
			
			
				<ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
				</ul>
		
			<!-- End Animation -->
			
		</section>
		<!-- The Modal -->
		<div id="myModal" class="modal">
			
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<span class="close">&times;</span>
					<h3 style="color:white;margin: 0 auto;color: #FF934B;font-weight: 700;">Select Course for Registration</h3>
				</div>
				<div class="modal-body">
					<div class="row">
						<table>
							<tr>
								<th>Image</th>
								<th>Course Name</th>
								<th>Class Name</th>
								<th>Action</th>
							</tr>
							@foreach ($courses as $key => $course)
							@php
							$color = '';
							if ($key % 4 == 1) {
							$color = 'sunset-orange';
							} elseif ($key % 4 == 2) {
							$color = 'green';
							} elseif ($key % 4 == 3) {
							$color = 'blue';
							} else {
							$color = 'orange';
							}
							@endphp
							@if($course->class_id)
							<tr>
								<td>
									<div class="course_item_img_inner" style="width: 40%; height: 40%">
										<img src="{{ asset($course->image) }}" alt="{{ $course->courseCategory->category_name }}" width="100px">
									</div>
								</td>
								<td>{{ $course->title }}</td>
								<td>
									@if($course->courseClass->class_name)
									{{ $course->courseClass->class_name }}
									@endif
									</td>
								<td>
									<a href="{{ URL::to('/onsite-nursery') }}" class="boxed_btn"><i class="fa fa-plus-circle"></i>@lang('edulia.register_your_account') with @if($course->courseClass->class_name) {{ $course->courseClass->class_name }} @endif </a>
								</td>
							</tr>
							@endif
							@endforeach
							</table>					
					</div>
				</div>
			</div>
			
		</div>
		<style>

			/* Start Animation */
			.login{
    /* background: #4e54c8;   */
    /* background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);   */
	background: linear-gradient(to bottom, #2D3436 0%, #FF934B 100%);
    width: 100%;
    height:100vh;
}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
    
}

.circles li:nth-child(1){
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}


.circles li:nth-child(2){
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3){
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4){
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5){
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6){
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7){
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8){
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9){
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10){
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}



@keyframes animate {

    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }

}
			/* End Animation */
			/* Start Form  */
			.input-control-input[type=submit] {
    background-color: #2D3436 !important;
}
				.login_wrapper {
				border: 2px solid #fff;
				padding: 20px;
				border-radius: 10px;
				background-color: #fff;
				box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
				z-index: 1;
				}
				.login_wrapper_logo {
				/* background-color: #2d3436; */
				padding: 10px;
				border-radius: 10px;
				}
				.login_wrapper_logo img {
				width: auto;
				max-height:140px;
				}
				.login_wrapper_content .input-control-input[type="submit"] {
				border-radius: 10px;
				}
				.login_wrapper_content p a {
				text-decoration: underline;
				}
				.login_wrapper_content h4 {
				font-size: 24px;
				line-height: 1.5;
				margin-top: 25px;
				margin-bottom: 0px;
				text-align: center;
				color: #FF934B;
				font-weight: bold;
				}
			/* End Form  */
			table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
			}
			
			td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
			}
			
			tr:nth-child(even) {
			background-color: #dddddd;
			}
			/* The Modal (background) */
			.modal {
			display: none; /* Hidden by default */
			position: fixed; /* Stay in place */
			z-index: 1; /* Sit on top */
			padding-top: 100px; /* Location of the box */
			left: 0;
			top: 0;
			width: 100%; /* Full width */
			height: 100%; /* Full height */
			overflow: auto; /* Enable scroll if needed */
			background-color: rgb(0,0,0); /* Fallback color */
			background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}
			
			/* Modal Content */
			.modal-content {
			position: relative;
			background-color: #fefefe;
			margin: auto;
			padding: 0;
			border: 1px solid #888;
			width: 80%;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
			-webkit-animation-name: animatetop;
			-webkit-animation-duration: 0.4s;
			animation-name: animatetop;
			animation-duration: 0.4s
			}
			
			/* Add Animation */
			@-webkit-keyframes animatetop {
			from {top:-300px; opacity:0} 
			to {top:0; opacity:1}
			}
			
			@keyframes animatetop {
			from {top:-300px; opacity:0}
			to {top:0; opacity:1}
			}
			
			/* The Close Button */
			.close {
			color: white;
			float: right;
			font-size: 28px;
			font-weight: bold;
			}
			
			.close:hover,
			.close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
			}
			
			.modal-header {
			padding: 2px 16px;
			background-color: #2D3436;
			color: white;
			}
			
			.modal-body {padding: 2px 16px;}
			
			.modal-footer {
			padding: 2px 16px;
			background-color: #1B4899;
			color: white;
			}
			.boxed_btn {
    background-color: #2D3436 !important;}
		</style>
		<!-- jQuery JS -->
		<script src="{{ asset('public/theme/edulia/js/jquery.min.js') }}"></script>
		
		<!-- Main Script JS -->
		<script src="{{ asset('public/theme/edulia/js/script.js') }}"></script>
		<script src="{{ asset('public/backEnd/') }}/js/login.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$("#email-address").keyup(function() {
					$("#username-hidden").val($(this).val());
				});
			});
		</script>
		<script>
			// Get the modal
			var modal = document.getElementById("myModal");
			
			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");
			
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks the button, open the modal 
			btn.onclick = function() {
				modal.style.display = "block";
			}
			
			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}
			
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
		</script>
	</body>
	
</html>
