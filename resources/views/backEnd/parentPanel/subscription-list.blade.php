<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subscription List</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<style>
@import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700);
body{background: linear-gradient(to bottom, #2d2535 0%, #5d1fa2 100%);width:100%;min-height:100vh;overflow-x:hidden;display:flex;flex-direction:column;padding:40px 0;justify-content:center;--bs-heading-color:#5d1fa2;}
.circles{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden;padding: 0;}
.circles li{position:absolute;display:block;list-style:none;width:20px;height:20px;background:rgba(255,255,255,0.2);animation:animate 25s linear infinite;bottom:-150px}
.circles li:nth-child(1){left:25%;width:80px;height:80px;animation-delay:0}
.circles li:nth-child(2){left:10%;width:20px;height:20px;animation-delay:2s;animation-duration:12s}
.circles li:nth-child(3){left:70%;width:20px;height:20px;animation-delay:4s}
.circles li:nth-child(4){left:40%;width:60px;height:60px;animation-delay:0;animation-duration:18s}
.circles li:nth-child(5){left:65%;width:20px;height:20px;animation-delay:0}
.circles li:nth-child(6){left:75%;width:110px;height:110px;animation-delay:3s}
.circles li:nth-child(7){left:35%;width:150px;height:150px;animation-delay:7s}
.circles li:nth-child(8){left:50%;width:25px;height:25px;animation-delay:15s;animation-duration:45s}
.circles li:nth-child(9){left:20%;width:15px;height:15px;animation-delay:2s;animation-duration:35s}
.circles li:nth-child(10){left:85%;width:150px;height:150px;animation-delay:0;animation-duration:11s}
@keyframes animate {
0%{transform:translateY(0) rotate(0deg);opacity:1;border-radius:0}
100%{transform:translateY(-1000px) rotate(720deg);opacity:0;border-radius:50%}
}
.container{z-index:9;position:relative;}
/* .snip1517{font-family:Arial,sans-serif;color:#fff;text-align:left;font-size:16px;width:100%;margin:30px 0;z-index:999} */
img{position:absolute;left:0;top:0;height:100%;z-index:-1}
.plan{padding:1rem;height: 100%;position:relative;border-radius:12px;background-color: hsl(267.13deg 15% 9%);background-image: radial-gradient(at 88% 40%, hsl(280.94deg 43.61% 13.93%) 0px, transparent 85%), radial-gradient(at 49% 30%, hsl(272.12deg 41.82% 22.69%) 0px, transparent 85%), radial-gradient(at 14% 26%, hsl(263.31deg 37.8% 14.52%) 0px, transparent 85%), radial-gradient(at 0% 64%, hsl(278.42deg 99% 26%) 0px, transparent 85%), radial-gradient(at 41% 94%, hsl(309.89deg 97% 36%) 0px, transparent 85%), radial-gradient(at 100% 99%, hsl(264.57deg 94% 13%) 0px, transparent 85%);}
.plan .card__border {overflow: hidden;pointer-events: none;position: absolute;z-index: -10;top: 50%;left: 50%;transform: translate(-50%, -50%);width: calc(100% + 2px);height: calc(100% + 2px);background-image: linear-gradient(0deg, hsl(298.56deg 100% 50%) -50%, hsl(0, 0%, 40%) 100%);}
.plan .card__border::before {content: "";pointer-events: none;position: fixed;z-index: 200;top: 50%;left: 50%;transform: translate(-50%, -50%), rotate(0deg);transform-origin: left;width: 200%;height: 10rem;background-image: linear-gradient(0deg, #ffffff00 0%, #ff1df6 40%, #ff1df6 60%, #66666600 100%);animation: rotate 8s linear infinite;}
@keyframes rotate {to {transform: rotate(360deg);}}
.plan.hover i{-webkit-transform:scale(1.2);transform:scale(1.2)}
*{-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-transition:all .25s ease-out;transition:all .25s ease-out}
header{color:#fff;border-bottom: 1px solid #d200ff2e;padding-bottom: 20px;margin-bottom: 20px;}
.plan-title{line-height:60px;position:relative;margin:0;padding:0 20px;font-size: 22px;/* letter-spacing:2px; */font-weight:700;color: #FFF;text-align: center;white-space: nowrap;}
.plan-title:after{position:absolute;/* content:''; */top:100%;left:20px;width:30px;height:3px;background-color:#fff}
.plan-cost{padding:0 20px;margin:0;text-align:center;}
.plan-cost span{display: block;}
.plan-price{font-weight:400;font-size:2.8em;/* margin:10px 0; */}
.plan-type{font-size: 0.8em;text-transform:uppercase;color:#ff00c2;}
.plan-features{padding:0 0 20px;margin:0;list-style:outside none none;font-size:.9em}
.plan-features li{padding:8px 20px}
.plan-features i{margin-right:8px;color:rgba(255,255,255,0.5)}
.plan-select{border-top: 1px solid #d200ff2e;padding:20px;text-align:center}
.plan-select a{border:1px solid #fff;color:#fff;text-decoration:none;padding:12px 20px;font-size:.75em;font-weight:600;border-radius:8px;text-transform:uppercase;letter-spacing:4px;display:inline-block}
.plan-select a:hover{background-color: #7f03c5 !important;border-color: #7f03c5;box-shadow: 0 0 70px #f304fc;}
.featured{margin-top:-10px;z-index:1;border-radius:8px;border:2px solid #156dab;background-color:#156dab}
.featured .plan-select{padding:30px 20px}
.featured .plan-select a{background-color:#10507e}
@media only screen and (max-width: 767px) {
/* .plan{width:49%;margin:.5%} */
.plan-title,.plan-select a{-webkit-transform:translateY(0);transform:translateY(0)}
.plan-select,.featured .plan-select{padding:20px}
.featured{margin-top:0}
.featured header{line-height:70px}
}
@media only screen and (max-width: 440px) {
/* .plan{margin:.5% 0;width:100%} */
}
.modal{position:fixed;top:0;right:0;bottom:0;left:0;background-color:rgba(0,0,0,0.5);display:none;justify-content:center;align-items:center}
.modal-background{top:0;right:0;bottom:0;left:0;background-color:rgba(0,0,0,0.5)}
.modal-content{background-color:#fff;padding:20px;border:1px solid #ddd;border-radius:10px;width:50%;margin:40px auto;box-shadow:0 0 10px rgba(0,0,0,0.2)}
.modal-header{padding:10px;border-bottom:1px solid #ddd}
.modal-title{margin:0}
.modal-body{padding:20px}
.modal-footer{padding:10px;border-top:1px solid #ddd;text-align:right}
.btn{background-color:#4CAF50;color:#fff;padding:10px 20px;border:none;border-radius:5px;cursor:pointer}
.btn:hover{background-color:#3e8e41}
.card{font-family:Arial,sans-serif;background-color: #ffffff82;border-radius: 0;padding: 20px;color: #707070;border: none;/* box-shadow:0 0 10px rgba(0,0,0,0.1); */}
.name,.email,.phone{margin-bottom:10px;/* color:#fff; */}
.name span,.email span,.phone span{/* color: #5c5c5c; */margin-right:10px}
.name,.email,.phone{font-size:16px;/* color:#fff; */}
@media (max-width: 768px) {
.col-sm-6{flex-basis:100%;max-width:100%}
}
.row{display:flex;color:#fff}
.modal-header{display:flex;justify-content:space-between;align-items:center}
.modal-title-container{flex:1}
.close{margin-left:10px}

.page-info{background: #ffffff;padding: 20px;/* border-radius: 30px; */border-top: 18px solid #520894;}
hr{border-top:1px solid #000000;}
.credits{line-height:20px;text-align:center;}

label.primary_input_label.initialize{width:100%;}
.field-container{margin-top:10px;}


</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="page-info">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="card">
							<h2>@lang('common.parent_details')</h2>
							<div class="name">
								<span>@lang('common.name'): {{$userParent->full_name}}</span>
							</div>
							<div class="email">
								<span>@lang('common.email'): {{$userParent->email}}</span>
							</div>
							<div class="phone">
								<span>@lang('common.phone'): {{$userParent->phone_number}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="card">
							<h2>@lang('common.student_details')</h2>
							<div class="name">
								<span>@lang('common.name'): {{$studentRecord->full_name}}</span>
							</div>
							{{--<div class="email">
								<span>@lang('common.email'): {{$studentRecord->email}}</span>
							</div>--}}
							<div class="phone">
								<span>@lang('common.phone'): {{$studentRecord->mobile}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-12 mb-4">
						<div class="card">
							<h2>@lang('common.course_details')</h2>
							<ul class="course-features">
									<li><i class="ion-android-remove"> </i>{{$courseDetails->title}}</li>
									<li><i class="ion-android-remove"> </i>{{$subscriptionPlans->courseCategory->category_name}}</li>
									<li><i class="ion-android-remove"> </i>{{$courseDetails->sectionClass->category_name}}</li>
								</ul>
						</div>
					</div>
					<div class="col-lg-3 col-sm-12 mb-4">
						<div class="card">
							<h2>@lang('common.subscription_plan')</h2>
							<ul class="course-features">
									<li><i class="ion-android-remove"> </i>{{$subscriptionPlans->name}}</li>
									<li><i class="ion-android-remove"> </i>{{$subscriptionPlans->price}}</li>
									<li><i class="ion-android-remove"> </i>{{$subscriptionPlans->description}}
										
									</li>
								</ul>
						</div>
					</div>

				</div>
				<div class="row">		
					<div class="col-12">
					<h2 class="text-center m-0 mt-4">@lang('common.choose_plans')</h2>
					</div>
						<div class="col mt-4">
							<div class="plan">
								<header>
									<h4 class="modal-title">@lang('common.make_payment')</h4>
									<div class="plan-select">
											<div class="showhide">
									      		<strong>@lang('common.initialize')</strong>
									      		<i class="fas fa-spinner fa-spin fa-lg text-primary"></i>
									      	</div>
									      <label class="primary_input_label initialize" for="">@lang('common.pay_with_card') <span class="text-danger">
									      <div id="card-element"></div>
									      <button class="btn btn-primary initialize" onclick="myFatoorahSubmit();" style="width:100%">
									        <span class="pay-now">@lang('common.pay_now')</span>
									      </button>
									</div>
								</header>
							</div>
						</div>
				</div>

			</div>
			<div class="credits">MetaShops</div>
		</div>
	</div>





</div>
{{-- 
<!-- Create a modal box -->
<div class="modal" id="myModal" style="z-index:9999;padding-right: 0px;">
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
      <label class="primary_input_label initialize" for="">Pay with card <span class="text-danger">
      <div id="card-element"></div>
      <button class="btn btn-primary initialize" onclick="myFatoorahSubmit();" style="width:100%">
        <span class="pay-now">Pay Now</span>
      </button>
    </div>
  </div>
</div>
--}}
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

	window.addEventListener('load', function() {
	  makePayment({{$subscriptionPlans->id}},{{$subscriptionPlans->price}});
	});

	function makePayment(planId,amountPay) {
			totalPaybleAmount = amountPay;
			SubsplanId = planId;
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
                	jquery('#card-element').html('');
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
	            CustomerName: "{{$userParent->full_name}}",
	            CustomerEmail: "{{$userParent->email}}",
	            InvoiceValue: totalPaybleAmount,
	            Language: "en",
	            DisplayCurrencyIso: "KWD",
	            MobileCountryCode:"965",
	            CustomerReference:"noshipping-nosupplier"
	        };
	        console.log(paymentRequest);
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