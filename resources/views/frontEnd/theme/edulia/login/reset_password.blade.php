<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset(generalSetting()->favicon) }}" type="image/png" />
    <title>@lang('auth.reset_password')</title>
    <meta name="_token" content="{!! csrf_token() !!}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/fontawesome.all.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/style.css') }}">
    <style>
        .text-danger.text-left {
            font-size: 14px;
        }

        /* Start Animation */
        .login{
    background: #4e54c8;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
    height:100vh;
    
   
}

.circles{
    /* position: absolute; */
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

        .login_wrapper{
            z-index: 1 !important;
        }
    </style>
</head>

<body>

    <section class="login">
        <div class="login_wrapper">
            <!-- login form start -->
            <div class="login_wrapper_login_content" style="border: 2px solid #fff;
    padding: 20px;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                <div class="login_wrapper_logo text-center" style="background-color: #2d3436;border-radius: 10px;padding: 10px;"><img  src="{{ asset(generalSetting()->logo) }}"
                        alt=""></div>
                <div class="login_wrapper_content">
                    <h4>@lang('auth.reset_password')</h4>
                        <div class="text-center">
                            @if(session()->has('message-success'))
                                <p class="text-success">{{session()->get('message-success')}}</p>
                            @endif
                        @if(session()->has('message-danger') != "")
                            @if(session()->has('message-danger'))
                                <p class="text-danger">{{session()->get('message-danger')}}</p>
                            @endif
                        @endif
                    
                    <form action="{{ route('email/verify') }}" method='POST'>
                        @csrf
                        <div class="input-control">
                            <label for="#" class="input-control-icon"><i class="fal fa-envelope"></i></label>
                            <input type="email" name='email' class="input-control-input"
                                placeholder='@lang('auth.enter_email_address')'
                                {{-- required --}}>
                            @if ($errors->has('email'))
                                <span class="text-danger text-left pl-3" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="input-control">
                            <input type="submit" class='input-control-input' value="Submit" style="border-radius: 10px;">
                        </div>
                    </form>
                </div>
            </div>
            <!-- login form end -->
        </div>

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
    </section>


    <!-- jQuery JS -->
    <script src="{{ asset('public/theme/edulia/js/jquery.min.js') }}"></script>

    <!-- Main Script JS -->
    <script src="{{ asset('public/theme/edulia/js/script.js') }}"></script>
</body>

</html>
