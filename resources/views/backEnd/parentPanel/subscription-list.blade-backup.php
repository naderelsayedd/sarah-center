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
		<div class="col-sm-6 card">
			<h2>Parent Details</h2>
			<div class="name">
				<span>Name: {{$userParent->full_name}}</span>
			</div>
			<div class="email">
				<span>Email: {{$userParent->email}}</span>
			</div>
			<div class="phone">
				<span>Phone: {{$userParent->phone_number}}</span>
			</div>
		</div>
		<div class="col-sm-6 card">
			<h2>Student	 Details</h2>
			<div class="name">
				<span>Name: {{$studentRecord->full_name}}</span>
			</div>
			<div class="email">
				<span>Email: {{$studentRecord->email}}</span>
			</div>
			<div class="phone">
				<span>Phone: {{$studentRecord->mobile}}</span>
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="snip1517">
			<?php foreach ($subscriptionPlans as $key => $value): ?>
				<div class="plan">
					<header>
					  <h4 class="plan-title">
					    {{$value->name}}
					  </h4>
					  <div class="plan-cost">
					  	<span class="plan-price">{{$value->price}}</span>
					  	<span class="plan-type">
					  		<?php if ($value->duration_type == 1) {
                                    echo "Yearly";
                                }else if($value->duration_type == 2){
                                    echo "Half Yearly";
                                }else if($value->duration_type == 3){
                                    echo "Quarterly";
                                }else if($value->duration_type == 4){
                                    echo "Monthly";
                                }
                            ?>
					  	</span></div>
					</header>
					<ul class="plan-features">
					  <li><i class="ion-android-remove"> </i>
					  		{{$value->description}}
					  </li>
					  <!-- <li><i class="ion-android-remove"> </i>5 MySQL Databases</li>
					  <li><i class="ion-android-remove"> </i>Unlimited Email</li>
					  <li><i class="ion-android-remove"> </i>250Gb mo Transfer</li>
					  <li><i class="ion-android-remove"> </i>24/7 Tech Support</li>
					  <li><i class="ion-android-remove"> </i>Daily Backups</li> -->
					</ul>
					<div class="plan-select"><a href="javascript:void(0)" onclick="makePayment({{$value->id}},{{$value->price}})">Select Plan</a></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>

<!-- Create a modal box -->
<div class="modal" id="myModal" style="z-index: 999;padding-right: 0px;">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="modal-header">
	  <div class="modal-title-container">
	    <h4 class="modal-title">Make Payment</h4>
	  </div>
	  <span type="button" class="close" data-dismiss="modal" aria-label="Close">
	    <i class="fas fa-times" aria-hidden="true"></i>
	  </span>
	</div>
    <div class="modal-body">
      <div class="showhide">
      		<strong>Please wait initializing...</strong>
      		<i class="fas fa-spinner fa-spin fa-lg text-primary"></i>
      	</div>
      <label class="primary_input_label initialize d-none" for="">Pay with card <span class="text-danger">
      <div id="card-element"></div>
      <button class="btn btn-primary initialize d-none" onclick="myFatoorahSubmit();" style="width:100%">
        <span class="pay-now">Pay Now</span>
      </button>
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
<script type="text/javascript">
	var jquery = jQuery.noConflict();
	/* Demo purposes only */
	jquery(".hover").mouseleave(
	  function() {
	    jquery(this).removeClass("hover");
	  }
	);
	var totalPaybleAmount = 0;
	var SubsplanId = 0;
	var myFatoorahEmail = 'Info@metashops.com.sa';
	var myFatoorahPassword ='Metashops@2022';
	var myFatoorahApiKey = "CfIpeEz3XUDvT-G3CDmSjhW2iO2IILZLUkaESyqSL744Npgeg-MEs7766PnXfetBnC7cmJb_a8Sen4XOdosxTxmdJfEnFMUFzEW8NJmT7ZbRM1SWqlFFRLgSAhpY4scSfiJsF0GMj1wB87PJowJL9ZvGCHGDjc7sStIpvCEOL-GOrJQxCeI3vvDjpxoSr2JkgV6fe6tbxjhvHXLEztpHiltv9MvTNrkrwnKMrSEB2nFAibNPzT2y7naGuC0WJJUY9etFTshdbvdXRb1kZymI135s71GlHmKcSgbrE2EnT7ve2cgwEMO9oA2ugsINpaXl7HsB4GEYamXD164Dm_JthRwM2kAqfb0NLXjQ0-Um01Iu8Z-yWW0BSw6z80sS2h-HROGAzBwkiVz90VHPcLY0cHSWBI1EC2ivblPuRLIcuNVdShp7of1eWq7pmxOCHfz-GJACtzdR8ne74nYr2Qu1UO6xWhJNxVSC4DPVgH57DHouROM1hVxSArtPmtC_VcNIAJjdCHVzaL_geHAfEaUY1YGEaDvu7sIsOoWn4Oa555jjUadS-tlaEZPC4OUSsAFV2K7Y-4gAmAar4liBF1dTddC28USyV_RFJHyKvyunSBkM2du6-0arGUxJ2SDRzg9UDfFgA-wnRnKzUgbUfbvdWasFjWw-yBBskyrzkBXSm5AWgoLr";
	function makePayment(planId,amountPay) {
			totalPaybleAmount = amountPay;
			SubsplanId = planId;
			document.getElementById('myModal').style.display = 'block';
           	jquery('#card-element').html('');
           	jquery('.showhide').show();
           	jquery('.initialize').hide();
            jquery.ajax({
                type: 'POST',
                url: "{{route('payment.getSessionId')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "Username": myFatoorahEmail,
                    "Password": myFatoorahPassword,
                    "ApiKey": myFatoorahApiKey
                },
                success: function(response) {
                	jquery('.showhide').hide();
                	jquery('#myModal').modal('show');
                	jquery('#card-element').html('');
			        // jquery('#myModal .modal-body').html('Payment successful! Session ID: ' + response.Data.SessionId);
                    if (response["IsSuccess"] === true) {
                        /*for card payment*/
                        jquery('.initialize').show();
                        var sessionId = response.Data.SessionId;
                        var config = {
                            countryCode: response.Data.CountryCode,
                            sessionId: sessionId,
                            cardViewId: "card-element",
                            supportedNetworks: "v,m,md,ae",

                        };
                        myFatoorah.init(config);

                        } else {
                            // toastr.error("InitiateSession error: ".response,"Failed", { timeOut: 5000,});
                        }
                },
                error: function(xhr, status, error) {
                    // toastr.error("AJAX request error:: ".error,"Failed", { timeOut: 5000,});
                }
            });
	}


	function myFatoorahSubmit() {
	    jquery('.pay-now').text('Please wait a bit...');
	    var myFatoorahApiKey = myFatoorahApiKey;
	    myFatoorah.submit().then(function(response) {
	        var sessionId = response.sessionId;
	        var cardBrand = response.cardBrand;
	        var cardIdentifier = response.cardIdentifier;
	        var paymentRequest = {
	            SessionId: sessionId,
	            CardBrand: cardBrand,
	            CardIdentifier : cardIdentifier,
	            Amount: totalPaybleAmount, 
	            CallBackUrl:"{{route('payment-success-callback')}}",
	            CurrencyCode: 'KWD',
	            CustomerName: "{{$userParent->full_name}}", // example customer name
	            CustomerEmail: "{{$userParent->email}}", // example customer email
	            CustomerMobile: "7456320", // example customer mobile number
	            InvoiceValue: totalPaybleAmount, // example invoice value
	            Language: "en",
	            DisplayCurrencyIso: "KWD",
	            MobileCountryCode:"965",
	            CustomerReference:"noshipping-nosupplier"
	        };

	        // Send the payment request to your server
	        jquery.ajax({
	            type: 'POST',
	            url: "{{route('subscription.makePayment')}}",
	            data: {
	                "_token" : "{{ csrf_token() }}",
	                "PaymentMethodId": "2", // Replace with your payment method ID
	                "InvoiceValue": totalPaybleAmount, // Replace with invoice value
	                "Language": "en", // Replace with language code (en or ar)
	                "paymentRequest" : paymentRequest,
	                "planId":SubsplanId,
	            },
	            success: function(response) {
	                jquery('.pay-now').html('Success');
	                if (response.status == 'success') {
	                    if(response.payment_url){
	                       window.location.href=response.payment_url;
	                    }else{
	                        location.reload();
	                    }
	                }else{
	                    jquery('.pay-now').html('Failed');
	                }
	            },
	            error: function(xhr, status, error) {
	                jquery('.pay-now').html('Pay Now');
	            }
	        });
	    }).catch(function(error) {
	        console.log(error);
	    });
	}
	function handleBinChanges(bin) {
	    console.log(bin);
	}
</script>
</body>
</html>