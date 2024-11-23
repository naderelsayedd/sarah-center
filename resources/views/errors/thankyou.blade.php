<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
       @import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
       @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700);
       body{
           background: linear-gradient(to bottom, #2D3436 0%, #FF934B 100%);
           width: 100%;
           height: 100vh;
           overflow-x: hidden;
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
       .container{
            padding:30px;
       }
       .snip1517 {
           font-family: Arial, sans-serif;
           color: #ffffff;
           text-align: left;
           font-size: 16px;
           width: 100%;
           margin: 30px 0px;
           z-index: 999;
       }
       .snip1517 img {
           position: absolute;
           left: 0;
           top: 0;
           height: 100%;
           z-index: -1;
       }
       .snip1517 .plan {
           margin: 0 0.5%;
           width: 24%;
           padding-top: 10px;
           position: relative;
           float: left;
           overflow: hidden;
           background-color: #222f3d9c;
           border-radius: 8px;
       }
       .snip1517 .plan.hover i {
           -webkit-transform: scale(1.2);
           transform: scale(1.2);
       }
       .snip1517 * {
           -webkit-box-sizing: border-box;
           box-sizing: border-box;
           -webkit-transition: all 0.25s ease-out;
           transition: all 0.25s ease-out;
       }
       .snip1517 header {
            color: #ffffff;
       }
       .snip1517 .plan-title {
           line-height: 60px;
           position: relative;
           margin: 0;
           padding: 0 20px;
           font-size: 1.6em;
           letter-spacing: 2px;
           font-weight: 700;
       }
       .snip1517 .plan-title:after {
           position: absolute;
           content: '';
           top: 100%;
           left: 20px;
           width: 30px;
           height: 3px;
           background-color: #fff;
       }
       .snip1517 .plan-cost {
           padding: 0 20px;
           margin: 0;
       }
       .snip1517 .plan-price {
           font-weight: 400;
           font-size: 2.8em;
           margin: 10px 0;
           display: inline-block;
       }
       .snip1517 .plan-type {
           opacity: 0.8;
           font-size: 0.7em;
           text-transform: uppercase;
       }
       .snip1517 .plan-features {
           padding: 0 0 20px;
           margin: 0;
           list-style: outside none none;
           font-size: 0.9em;
       }
       .snip1517 .plan-features li {
            padding: 8px 20px;
       }
       .snip1517 .plan-features i {
           margin-right: 8px;
           color: rgba(255, 255, 255, 0.5);
       }
       .snip1517 .plan-select {
           border-top: 1px solid rgba(0, 0, 0, 0.2);
           padding: 20px;
           text-align: center;
       }
       .snip1517 .plan-select a {
           border: 1px solid white;
           color: #ffffff;
           text-decoration: none;
           padding: 12px 20px;
           font-size: 0.75em;
           font-weight: 600;
           border-radius: 8px;
           text-transform: uppercase;
           letter-spacing: 4px;
           display: inline-block;
       }
       .snip1517 .plan-select a:hover {
            background-color: #1b8ad8 !important;
       }
       .snip1517 .featured {
       margin-top: -10px;
       z-index: 1;
       border-radius: 8px;
       border: 2px solid #156dab;
       background-color: #156dab;
       }
       .snip1517 .featured .plan-select {
       padding: 30px 20px;
       }
       .snip1517 .featured .plan-select a {
       background-color: #10507e;
       }
       @media only screen and (max-width: 767px) {
       .snip1517 .plan {
       width: 49%;
       margin: 0.5%;
       }
       .snip1517 .plan-title,
       .snip1517 .plan-select a {
       -webkit-transform: translateY(0);
       transform: translateY(0);
       }
       .snip1517 .plan-select,
       .snip1517 .featured .plan-select {
       padding: 20px;
       }
       .snip1517 .featured {
       margin-top: 0;
       }
       .snip1517 .featured header {
       line-height: 70px;
       }
       }
       @media only screen and (max-width: 440px) {
       .snip1517 .plan {
       margin: 0.5% 0;
       width: 100%;
       }
       }
       /* Modal styles */
       .modal {
       position: fixed;
       top: 0;
       right: 0;
       bottom: 0;
       left: 0;
       background-color: rgba(0, 0, 0, 0.5);
       display: none;
       justify-content: center;
       align-items: center;
       }
       .modal-background {
       top: 0;
       right: 0;
       bottom: 0;
       left: 0;
       background-color: rgba(0, 0, 0, 0.5);
       }
       .modal-content {
       background-color: #fff;
       padding: 20px;
       border: 1px solid #ddd;
       border-radius: 10px;
       width: 50%;
       margin: 40px auto;
       box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
       }
       .modal-header {
       padding: 10px;
       border-bottom: 1px solid #ddd;
       }
       .modal-title {
       margin: 0;
       }
       .modal-body {
       padding: 20px;
       }
       .modal-footer {
       padding: 10px;
       border-top: 1px solid #ddd;
       text-align: right;
       }
       .btn {
       background-color: #4CAF50;
       color: #fff;
       padding: 10px 20px;
       border: none;
       border-radius: 5px;
       cursor: pointer;
       }
       .btn:hover {
       background-color: #3e8e41;
       }
       /* Global styles */


    /* Card styles */
    .card {
        font-family: Arial, sans-serif;
        background-color: #00000042;
        border-radius: 10px;
        padding: 20px;
        color: white;
        margin: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Column styles */
    .col-sm-6 {
      flex-basis: 40%;
      max-width: 40%;
    }

    /* Name, Email, Phone styles */
    .name, .email, .phone {
      margin-bottom: 10px;
      color: white;
    }

    .name span, .email span, .phone span {
      font-weight: bold;
      color: white;
      margin-right: 10px;
    }

    .name, .email, .phone {
      font-size: 16px;
      color: white;
      color: #333;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .col-sm-6 {
            flex-basis: 100%;
            max-width: 100%;
        }
    }
    .row{
        display: flex;
        color: white;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-title-container {
      flex: 1;
    }

    .close {
      margin-left: 10px;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 card" style="z-index: 999;width: 100%;margin: 5rem 10rem 0rem 10rem;">
            <div class="max-w-sm m-8" style="text-align: center;">
                <div class="text-black text-5xl md:text-15xl font-black">
                    <h1>Thank You for Your Subscription Purchase!</h1>
                </div>
                <div class="w-16 h-1 bg-purple-light my-3 md:my-6"></div>

                <p class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal text-white">
                    <p>We appreciate your subscription purchase and are thrilled to have you on board!</p>
                    <p>Your subscription has been successfully activated, and you can now access all the benefits and features of our service.</p>
                    <p>Thank you again for choosing our subscription service. We're committed to providing you with an exceptional experience.</p>
                    <br>
                </p>

                <a href="{{url('/login')}}" style="cursor: pointer;">
                    <button class="btn btn-dark">
                        Login
                    </button>
                </a>
                <p style="padding-top:20px;">&copy; <?php echo date("Y"); ?> All rights reserved.</p>
            </div>
        </div>
    </div>
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
<script src="https://demo.myfatoorah.com/cardview/v2/session.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>