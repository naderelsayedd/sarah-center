<?php
	$ttl_rtl = $setting->ttl_rtl;
?>

<!doctype html>
<html lang="ar">
	
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="{{asset(generalSetting()->favicon)}}" type="image/png"/>
		<meta name="_token" content="{!! csrf_token() !!}"/>
		<link rel="stylesheet" href="{{asset('public/backEnd/login2')}}/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{asset('public/backEnd/login2')}}/themify-icons.css">
		
		<link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/css/nice-select.css" />
		<link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/js/select2/select2.css" />
		
		<link rel="stylesheet" href="{{asset('public/backEnd/login2')}}/css/style.css">
		<link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/toastr.min.css"/>
		<title>{{isset($setting)? !empty($setting->site_title) ? $setting->site_title : 'System ': 'System '}} | @lang('auth.login')</title>
		<style>
			
			.loginButton {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			}
			
			.loginButton{
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			}
			.singleLoginButton{
			flex: 22% 0 0;
			}
			
			.loginButton .get-login-access {
			display: block;
			width: 100%;
			border: 1px solid #fff;
			border-radius: 5px;
			margin-bottom: 20px;
			padding: 5px;
			white-space: nowrap;
			}
			@media (max-width: 576px) {
			.singleLoginButton{
			flex: 49% 0 0;
			}
			}
			@media (max-width: 576px) {
			.singleLoginButton{
			flex: 49% 0 0;
			}
			.loginButton .get-login-access {
			margin-bottom: 10px;
			}
			}
			.create_account a {
			color: #828bb2;
			font-weight: 500;
			text-decoration: none;
			}
			
			#select-school{
			border: 0px;
			border-radius: 0px;
			border-bottom: 1px solid #d3cddd;
			}
			
			.nice-select:after {
			content: "\e62a";
			font-family: "themify";
			border: 0;
			transform: rotate(0deg);
			margin-top: -16px;
			font-size: 12px;
			font-weight: 500;
			right: 18px;
			transform-origin: none;
			-webkit-transition: all 0.1s ease-in-out;
			-moz-transition: all 0.1s ease-in-out;
			-o-transition: all 0.1s ease-in-out;
			transition: all 0.1s ease-in-out;
			}
			
			.nice-select.open:after {
			-webkit-transform: rotate(180deg);
			-moz-transform: rotate(180deg);
			-ms-transform: rotate(180deg);
			-o-transform: rotate(180deg);
			transform: rotate(180deg);
			margin-top: 15px;
			}
			.niceSelect {
			border: 0px;
			border-bottom: 1px solid rgba(130, 139, 178, 0.3);
			border-radius: 0px;
			-webkit-appearance: none;
			-moz-appearance: none;
			color: #828bb2;
			font-size: 12px;
			font-weight: 500;
			text-transform: uppercase;
			padding: 0;
			background: transparent;
			}
			.niceSelect:focus,.niceSelect:hover{
			border-color: rgba(130, 139, 178, 0.3);
			outline: none;
			box-shadow: none !important;
			}
			.mb-26{
			margin-bottom: 26px;
			}
			
			.nice-select.open .list {
			left: 0;
			position: absolute;
			right: 0;
			}
			.nice-select .nice-select-search {
			box-sizing: border-box;
			background-color: #fff;
			border: 1px solid rgba(130, 139, 178, 0.3);
			border-radius: 3px;
			box-shadow: none;
			color: #333;
			display: inline-block;
			vertical-align: middle;
			padding: 0px 8px;
			width: 100% !important;
			height: 36px;
			line-height: 36px;
			outline: 0 !important;
			}
			.nice-select .list {
			margin-top: 5px;
			top: 100%;
			border-top: 0;
			border-radius: 0 0 5px 5px;
			max-height: 210px;
			overflow-y: scroll;
			padding: 52px 0 0;
			left: 0 !important;
			right: 0 !important;
			}
			.niceSelect span.current {
			width: 85% !important;
			overflow: hidden !important;
			display: block !important;
			}
			/* Start Styles */
			.in_login_content img{
			max-width: fit-content !important;
			/* margin-bottom: 35px  !important;  */
			}
			/* End Styles */
			
			.in_login_page_header{/* background-color:#FFF !important;padding:20px; */}
			.side-img{background-size:cover;background-position:center;}
			.in_login_page_header h5{/* color:#520894; */background:none;padding:10px 0;}
			/* .in_login_page_iner form{padding:20px 80px;} */
			.in_single_input{margin-bottom:18px;}
			.in_single_input input{padding:0 37px 10px;}
			.create_account p{margin-top:14px;}
		</style>
	</head>
	<body >
		<div class="in_login_part mb-40"  style="{{$css}}">
			<div class="container" style="padding:0 50px;">
				<div class="row justify-content-center">
					<div class="col-lg-5 col-md-4 side-img" style="background-image:url({{ asset($course->image) }})"></div>
					<!-- <div class="col-sm-8 col-lg-5 col-xl-10 col-md-7"> -->
					<div class="col-lg-7 col-md-8" style="padding:0;">
						<div class="in_login_content">
							
							<div class="in_login_page_iner">
								<div class="in_login_page_header" style="display: flex;justify-content: space-between;align-items: center;">
									@if(!empty($setting->logo))<img src="{{asset($setting->logo)}}" style="max-width:50%;max-height:40px;margin:0;" alt="Login Panel">@endif
									<h5 style="font-size: 18px;"> {{__('Registration')}} @lang('common.details')</h5>
								</div>
								
								<div class="in_login_page_body">
									<div class="course_item_img" >
										<!-- <div class="course_item_img_inner" style="float:left; ">
											<img style="width: 100%;" src="{{ asset($course->image) }}" alt="{{ $course->courseCategory->category_name }}">
										</div> -->
										<div class="package-info-box">
											<div class="row no-gutters">
												<div class="col-sm-6">
													@if($subscriptionPlans->courseCategory->category_name)
													<div>
														<span class="course_item_img_status_right">@lang('common.category_name'): {{ $subscriptionPlans->courseCategory->category_name }}</span>
													</div>
													@endif 
												</div>
												<div class="col-sm-6">
													<div>
														<span class="course_item_img_status_right">@lang('common.subscription_plan'): {{ $subscriptionPlans->name }}</span>
													</div>
												</div>
											</div>
											<div class="row no-gutters">
												<div class="col-sm-6">
													@if($subscriptionPlans->sectionClass->category_name)
													<span class="course_item_img_status_right">({{ $subscriptionPlans->sectionClass->category_name }})</span>
													@endif
												</div>
												<div class="col-sm-6">
													<div>
														<span class="course_item_img_status_right">@lang('common.price'): {{ $subscriptionPlans->price }}</span>
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<h1 style="font-size:30px;margin:20px 0;color:#1d92ee;">@lang('common.parent_account_info')</h1>
									<form method="POST" class="loginForm" action="{{route('customer_register',['class_id' => $class_id, 'course_id' => $course_id])}}" id="infix_form">
										@csrf
										
										<input type="hidden" name="school_id" value="1">
										<input type="hidden" name="username" id="username-hidden">
										<input type="hidden" name="admission_number" value="{{$studentLastId}}">
										<input type="hidden" name="class_id" value="{{$class_id}}">
										<input type="hidden" name="course_id" value="{{$course_id}}">
										<input type="hidden" name="section_id" value="{{$classSection->section_id}}">
										<input type="hidden" name="student_category" value="{{$subscriptionPlans->sectionClass->id}}">
										<input type="hidden" name="subscription_plan" value="{{ $subscriptionPlans->id }}">
										<?php if(session()->has('message-danger') != ""): ?>
										<?php if(session()->has('message-danger')): ?>
										<p class="text-danger"><?php echo e(session()->get('message-danger')); ?></p>
										<?php endif; ?>
										<?php endif; ?>
										<input type="hidden" id="url" value="{{url('/')}}">		
										
										<div class="row">
											<div class="col-6">
												<div class="in_single_input">
													<input type="text" placeholder="@lang('auth.fathers_name')" name="fathers_name" class="{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}" value="{{old('fathers_name')}}" id="fathers_name">
													<span class="addon_icon">
														<i class="ti-user"></i>
													</span>
													@if ($errors->has('fathers_name'))
													<span class="text-danger text-left pl-3 d-block" role="alert">
														{{ $errors->first('fathers_name') }}
													</span>
													@endif
												</div>
											</div>
											<div class="col-6">
												<div class="in_single_input">
													<input type="text" placeholder="@lang('auth.fathers_phone')" name="fathers_phone" class="{{ $errors->has('fathers_phone') ? ' is-invalid' : '' }}" value="{{old('fathers_phone')}}" id="fathers_phone">
													<span class="addon_icon">
														<i class="ti-phone"></i>
													</span>
													@if ($errors->has('fathers_phone'))
													<span class="text-danger text-left pl-3 d-block" role="alert">
														{{ $errors->first('fathers_phone') }}
													</span>
													@endif
												</div>
											</div>
										</div>
										
										<div class="in_single_input">
											<input type="text" placeholder="@lang('auth.enter_father_email')" name="guardians_email" class="{{ $errors->has('guardians_email') ? ' is-invalid' : '' }}" value="{{old('guardians_email')}}" id="guardians_email-address">
											<span class="addon_icon">
												<i class="ti-email"></i>
											</span>
											@if ($errors->has('guardians_email'))
											<span class="text-danger text-left pl-3 d-block" role="alert">
												{{ $errors->first('guardians_email') }}
											</span>
											@endif
										</div>
										
										<div class="row">
											<div class="col-6">
												<div class="in_single_input">
													<input type="text" placeholder="@lang('common.registerd_by')" name="registered_by"
													class="{{ $errors->has('registered_by') ? ' is-invalid' : '' }}" value="{{old('registered_by')}}">
													@if ($errors->has('registered_by'))
													<span class="text-danger text-left pl-3 d-block" role="alert">
														{{ $errors->first('registered_by') }}
													</span>
													@endif
												</div>
											</div>
											<div class="col-6">
												<div class="in_single_input">
													<input type="password" placeholder="@lang('auth.enter_fathers_password')" name="fathers_password" class="{{ $errors->has('fathers_password') ? ' is-invalid' : '' }}" value="{{old('fathers_password')}}">
													<span class="addon_icon">
														<i class="ti-key"></i>
													</span>
													@if ($errors->has('fathers_password'))
													<span class="text-danger text-left pl-3 d-block" role="alert">
														{{ $errors->first('fathers_password') }}
													</span>
													@endif
												</div>
											</div>
											<div class="col-6">
												<div class="in_single_input">
													<input type="password" placeholder="@lang('auth.enter_confirm_fathers_password_confirmation')" name="fathers_password_confirmation"
													class="{{ $errors->has('fathers_password_confirmation') ? ' is-invalid' : '' }}" value="{{old('fathers_password_confirmation')}}">
													<span class="addon_icon">
														<i class="ti-key"></i>
													</span>
													@if ($errors->has('fathers_password_confirmation'))
													<span class="text-danger text-left pl-3 d-block" role="alert">
														{{ $errors->first('fathers_password_confirmation') }}
													</span>
													@endif
												</div>
											</div>
										</div>
										
										
										<h1 style="font-size:30px;margin:20px 0;color:#1d92ee;">@lang('common.child_account_info')</h1>
										
										@for($i = 0; $i < $subscriptionPlans->number_of_student; $i++)
											@if($subscriptionPlans->number_of_student > 1)
											@if($i == 0)
											<h5>@lang('common.enter_1')</h5>
											@elseif($i == 1)
											<h5>@lang('common.enter_2')</h5>
											@elseif($i == 2)
											<h5>@lang('common.enter_3')</h5>
											@elseif($i == 3)
											<h5>@lang('common.enter_4')</h5>
											@elseif($i == 4)
											<h5>@lang('common.enter_5')</h5>
											@elseif($i == 5)
											<h5>@lang('common.enter_6')</h5>
											@endif
											@endif
											<div class="row">
												<div class="col-6">
													<div class="in_single_input">
														<input required type="text" placeholder="@lang('auth.enter_name')" name="first_name[]" id="first_name" required>
														<span class="addon_icon">
															<i class="ti-user"></i>
														</span>
													</div>
												</div>
												<div class="col-6">
													<div class="in_single_input">
														<input type="text" placeholder="@lang('auth.phone_number')" name="phone_number[]" id="phone_number">
														<span class="addon_icon">
															<i class="ti-phone"></i>
														</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-6">
													<div class="primary_input mb-40 in_single_input">
														<select class="mb-26 niceSelect infix_theme_style w-100 bb form-control" name="gender[]" id="select-section" required>
															<option data-display="@lang('common.select_gender') *" value="">@lang('common.select_gender') *</option>
															<option value="1">@lang('common.male')</option>
															<option value="2">@lang('common.female')</option>
															<option value="3">@lang('common.others')</option>
														</select>
													</div>
												</div>
												<div class="col-6">
													<div class="primary_input mb-40 in_single_input">
														<?php 
															$duration = explode(',',$course->sectionClass->duration);
														?>
														<select class="mb-26 niceSelect infix_theme_style w-100 bb form-control" name="duration[]" id="select-section" required>
															<option data-display="@lang('common.duration') *" value="">@lang('common.duration') *</option>
															<?php foreach ($duration as $key => $value): ?>
															<option value="{{$value}}">{{$value}}</option>
															<?php endforeach ?>
														</select>
													</div>
												</div>	
												
											</div>
											@endfor
											<div class="row">
												<div class="col-6">
													<input required type="checkbox" id="term_and_conditions" name="term_and_conditions" value="1" style="display:block; float:left" onclick="checkTermsConditionsFalse();">
													<label for="term_and_conditions" style="margin-left:10px; float;right"><a  for="term_and_conditions" href="javascript:void(0)" id="myBtn">@lang('auth.term_and_conditions')</a></label>
												</div>
												
											</div>
											
											{{-- <div class="d-flex justify-content-between">
												<div class="in_checkbox">
													<div class="boxes">
														<input type="checkbox" id="Remember">
														<label for="Remember">@lang('auth.remember_me')</label>
													</div>
												</div>
												<div class="in_forgot_pass">
													<a href="{{url('recovery/passord')}}">@lang('auth.forget_password') ? </a>
												</div>
											</div> --}}
											<div class="in_login_button text-center">
												<button type="submit" class="in_btn" id="btnsubmit" style="background:#1d92ee;padding:18px 0;border-radius:0;box-shadow:none;margin-top:10px;">
													<span class="ti-lock"></span>
													{{__('Register')}}
												</button>
											</div>
											<div class="create_account text-center">
												<p>Already have an account? <a href="{{url('login')}}">Login Here</a></p>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- The Modal -->
			<div id="myModal" class="modal">
				
				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						
						<h3 style="color:white;margin: 0 auto;color: #FF934B;font-weight: 700; text-align: right">@lang('auth.term_and_conditions')</h3>
						<span class="close">&times;</span>
					</div>
					<div class="modal-body">
						<!--
							<div class="container" style="font-size:16px;line-height:30px; direction:rtl;     text-align: right;">
							<div class="row">
							<div class="col-12">
							<h3 class="text-center mb-30">عقد اتفاق تسجيل طفل</h3>
							<strong>نأمل من حضرتكم قراءة البنود بتمعن والموافقة عليها فهذه بنود ثابته خاصة بمصلحة الأطفال بشكل خاص والمركز بشكل عام:</strong>
							<ul style="list-style:none;">
							<li>1.  أعي أنه بمجرد تسجيل طفلي/طفلتي بأنني موافق على الالتزام بجميع قوانين ولوائج المركز، أعي بأن جميع القرارات الصادرة من الإدارة هي قرارات نهائية.</li>
							<li>2. أعي بأنه يجب دفع الرسوم مسبقا. وأنا أوافق على دفع جميع الرسوم في موعدها أو قبل انتهاء الاشتراك حسب التاريخ المسجل في الإيصال، وفي حال التقسيط يجب التزامي بدفع القسط بتاريخه وسيتم إيقاف اشتراك طفلي في حال تعذر دفعه. </li>
							<li>3. أعي أنه يجب دفع المبلغ مقدما لحجز مكان الطفل. أي تاخير في الدفع سيتم إلغاء مكان الطفل، مبلغ حجز المقعد المبكر 300 ريال تدخل من ضمن سعر الاشتراك، وغير قابلة للاسترداد في حال الانسحاب من الاشتراك. </li>
							<li><strong><u>4. أعى بأن رسوم التسجيل التى يتم دفعها غير مسترجعة لأى سبب.</u></strong></li>
							<li>5. أعي أنه يتوجب عليّ إعلام المركز فورًا في حال تغيير أرقام الهواتف أو تغيير رقم الطوارئ. </li>
							<li>6. أعي بأنه يتوجب على إعلام معلمة طفلي، وإدارة المركز بأي مشكلة لدى طفلي تمنعه من المشاركة في نشاط معين. </li>
							<li>7. أنا على دراية تامة بأوقات ومواعيد المركز الصباحية من الساعة 6 ص حتى 6 م وأعي أنه يجب اتباعها بدقة وأن اتحمل رسوم التأخير</li>
							<li>8. أعي أنه في حال تأخير الطفل عن عدد الساعات المختارة يحسب مبلغ تأخير قدره 30 ريال لكل نصف ساعة و60 بعد مرور ساعة.</li>
							<li>9. لا يوجد أي خصومات أو تعويض أو استرجاع مبلغ لأي سبب (اجازة مرضية، سفرا انتقال، جائحة...).</li>
							<li>10. أعي أنه يجب على الإفصاح عن أي مشاكل صحية أو سلوك عدواني أو أساليب خاطنة لدى طفلي حتى أتجنب إلغاء اشتراك طفلي وعدم استرجاع أي مبلغ، وأن افصاحي لها بهدف تعاون المركز معي بحلها وإفادتي بخطة تعديل سلوك. </li>
							<li>11. أعي أنه عليّ إنزال طفلي بنفسي من السيارة وتسليمه للعاملة عند باب المركز. </li>
							<li>12. يتعذر على إدارة المركز التواصل مع الآباء فيما يخص مشاكل الأطفال والاشتراك إلا في حال الطلاق.</li>
							<li>
							<strong><u>13. أعي أنه لدى المركز الحق بأن يلغى اشتراك أي طفل أو عدم تجديد اشتراك للأسباب التالية:</u></strong> 
							<ul style="list-style:none;">
							<li>1- إذا كان للطفل احتياجات خاصة (نعتذر وذلك لعدم وجود صلاحيات من التنمية الاجتماعية باستقبالهم).</li>
							<li>2- سلوكيات خاطئة غير قابله للتعديل.</li>
							<li>3- في حال عدم إفصاح ولي الأمر عن أي مشكلة عقلية، أو نفسية، أو جسدية، أو صحية. </li>
							<li>4- عدم تكيف الرضع بعد مرور أسبوعين من الاشتراك.</li>
							<li>5- عندما تؤثر احتياجات الرضيع الزائدة سلبا على مصلحة بقية الرضع (حمله طوال الوقت بكاء متواصل، أساليب رعاية خاطئة من قبل أولياء الأمور، إحضار الأجهزة الالكترونية).</li>
							<li>6- إذا كان لدى الطفل سلوك غير مقبول ولم يتم الإفصاح عنه مثل (عدوانية، عض، بصق، ضرب، ألفاظ غير لائقة وغيرها)؛ أسباب أخرى لمصلحة بقية الأطفال. </li>
							<li>7- عند إساءة ولي الأمر إلى أحد موظفات المركز، أو العاملات أو الحارس.</li>
							</ul>
							</li>
							<li>14. المركز غير مسؤول عن عدم قراءة ولي الأمر لعقد الاتفاق وسوف يتم تطبيق العقد كما هو.</li>
							<li>15. عدم تقيد ولي الأمر بالعقد المتفق عليه.</li>
							
							<div class="in_login_button text-center">
							<button type="buttom" class="in_btn"  onclick="checkTermsConditions();" style="background:#520894;padding:18px 0;border-radius:0;box-shadow:none;margin-top:10px;">
							<span class="ti-lock"></span>
							Agreed
							</button>
							</div>
							</ul>
							</div>
							</div>
							</div>
						-->
						<div class="contract-container">
							
							<h2 class="text-center">العقد</h2>
							<h3 class="text-center">عقد تسجيل اشتراك طفل في مركز سارة النموذجي:</h3>
							<strong>الطرف الأول: مركز سارة النموذجي لضيافة الأطفال الاهلية.</strong><br>
							<strong>الطرف الثاني: <span><!-- Father Name Here.. --></span>.</strong>
							<p>نعم أنا <span><!-- Father Name Here.. --></span> ارغب في تسجيل الطفلــــــ/ــة تحت رعاية ومسؤولية المركز وإلحاقهم بالاشتراك في القسم المذكور أعلاه فقد اتفق الطرفان على تسجيل الطفلـــ/ــة بالمركز على ان يلتزم الطرف الثاني بالتقيد بالأنظمة والسياسات المتبعة وهي كالتالي:</p>
							<h4>السياسات والأنظمة المتبعة في مركز سارة النموذجي.</h4>
							<h5>1- أوقات الحضـــــــور والانصراف:</h5>
							<ul>
								<li>على ولي امر المشترك / ــه الالتزام بأوقات الحضور والانصراف للطفلـــ/ــة في الوقت المطلوب منه ويحق للمركز فرض رسوم إضافية في حال عدم التقيد بأوقات الانصراف.</li>
							</ul>
							<h5>2- الاستبعــــــاد من المــــركــــــــــــــــــــــــــــــــز:</h5>
							<ul>
								<li>يحق لطرف الأول استبعاد الطفل المشترك /ــة من المركز بدون أن يتحمل المركز أي مسؤولية مالية أو تعويضية ويلتزم الطرف الثاني بسداد أي رسوم متبقية وذألك في الحالات التالية:</li>
								<ul>
									<li>عدم التقيد بوقت الانصراف المتفق علية .</li>
									<li>إلحاق الضرر بالطرف الأول او أحد منسوبيه.</li>
									<li>وجود مستحقات للطرف الأول ولم يتم سدادها في الاجل المستحق والمتفق علية.</li>
									<li>عدم افصاح ولي الأمر بأي مشاكل صحية أو سلوكية للطفلــــ/ـــة المشترك .&nbsp;</li>
								</ul>
							</ul>
							<h5>3- نظـــام وسياســـــــــــة الغيـــــــــاب:</h5>
							<ul>
								<li>الغياب بدون عذر طبي لا يعوض ابدا</li>
							</ul>
							<h5>4- نظـــام وسياســـــــــــة التجميد والتعويــــض:</h5>
							<ul>
								<li>يمكنك التقدم بطلب والاستفادة من تجميد الاشتراك مرة واحد في الشهر حيث ان النظام يسمح بتجميد الاشتراك لمدة (5) أيام فقط عند وجود عذر طبي .</li>
							</ul>
							<h5>5- نظـــام وسياســـــــــــة استرداد الرســـــــوم:</h5>
							<ul>
								<li>فيما يتعلق باسترداد الرسوم المدفوعة في حال رغبتكم في سحب الطفل / ــة من المركز يتم اعتماد تاريخ الانسحاب بمجرد الإبلاغ رسميا وما يترتب علية ذلك من فقدان المركز فرصة الحاق أطفال اخرين بنفس العقد.</li>
								<li>في حال انسحاب الطفلـــ/ـــة وقد تم صدور فاتورة بقيمة الاشتراك فان المبلغ لا يسترجع ابدا</li>
							</ul>
							<h5>6- نظـــام وسياســـــــــــة تجديد الاشتراك:</h5>
							<ul>
								<li>أن في حال نهاية الاشتراك سوف يتم ارسال رسالة تذكير الى ولي الأمر (بالتجديد + قيمة الاشتراك) عن طريق التطبيق في عدم تجديد الاشتراك يحق للمركز الغاء العقد وإلحاق أطفال اخرين بنفس العقد.</li>
								<li>في حال تجديد الاشتراك يعتبر العقد مستمر بكافة بنوده، ولا يحق لولي الأمر الغاء الاشتراك فيما بعد وتعتبر رسوم الاشتراك واجبة الدفع.</li>
							</ul>
							<h5>7- حقوق المشتركين في مركز سارة النموذجي:</h5>
							<ul>
								<li>الحصول على الخدمة المطلوبة بأفضل طريقة ممكنة.</li>
								<li>عدم الإساءة للطفلــــــ/ـــة بأي شكل من الاشكال (نفسيا &ndash; لفضيا &ndash; جسديا)</li>
								<li>توفير الرعاية المطلوبة من مقدمي الخدمة المؤهلين ومكان امن ونظيف.</li>
								<li>يحق للمشتركين وغير المشتركين بتقديم شكوى على الرقم (0556902250) وسوف يتم حل الشكوى في أقل من 24 ساعة.&nbsp;</li>
							</ul>
							<h5>8- التعليم عن بعد</h5>
							<ul>
								<li>لن يتم تجميد الاشتراكات في الاجازات المدرسية وسيكون المركز مستعد لاستقبال الاطفال حضوريا</li>
								<li>سوف يتم تفعيل التعليم عن بعد للاطفال الذين لايستطيعون الحضور للمركز خلال الاجازات المدرسية</li>
							</ul>
							<h4>بنود خاصة بقسم الحضانة</h4>
							<ul>
								<li>توفير مستلزمات حقيبة الطفل: الرضيع /(حليب &ndash; ماء معقم &ndash; مناديل مبللة &ndash; ملابس- كريم الحساسية &ndash; لوشن للجسم &ndash; حفاظ &ndash; معطر &ndash; مشط &ndash; أدوات الأكل)</li>
								<li>توفير وجبات الأكل في حال كان الطفل يأكل وجبات معينة .</li>
							</ul>
							<h4>بنود خاصة بقسم الروضة</h4>
							<ul>
								<li>توفير مستلزمات حقيبة الطفل: (ملابس احتياط &ndash; زمزمية الماء &ndash; سناك صحي &ndash; الكتب التعليمية)</li>
							</ul>
							<p>* ملاحظة: (وجبة الإفطار الصحية مجانية من قبل المركز)</p>
							
							<h4>بنود خاصة بقسم التربية الخاصة</h4>
							<ul>
								<li>توفير تقرير طبي معتمد بحالة الطفل</li>
							</ul>
							<h4>بنود خاصة بقسم التقوية المكثفة</h4>
							<ul>
								<p>ارسال الواجبات المدرسية والملاحظات عبر التطبيق في الوقت المحدد .</p>
							</ul>
							<h4 class="important-head">إقـــــــــــــــــــــــــرار ولي الأمر</h4>
							
							<p>اتعهد بالالتزام بكل ماورد في عقد الالتحاق من بنود وتعليمات وهذا إقرار مني بذألك ..</p>
							
							
						<div class="in_login_button text-center">
												<button type="buttom" class="in_btn"  onclick="checkTermsConditions();" style="background:#520894;padding:18px 0;border-radius:0;box-shadow:none;margin-top:10px;">
													<span class="ti-lock"></span>
													Agreed
												</button>
											</div>
							
						</div>
						
						
					</div>
				</div>
				
			</div>
			
			<!--================ Footer Area =================-->
			<footer class="footer_area min-height-10" style="margin-top: -50px;">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-12 text-center">
							<p style="color: #828bb2">{!! generalSetting()->copyright_text !!} </p>
						</div>
					</div>
				</div>
			</footer>
			
			
			<!--================ End Footer Area =================-->
			<script src="{{asset('public/backEnd/login2')}}/js/jquery-3.4.1.min.js"></script>
			<script src="{{asset('public/backEnd/login2')}}/js/popper.min.js"></script>
			<script src="{{asset('public/backEnd/login2')}}/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/toastr.min.js"></script>
			<script src="{{asset('public/backEnd/')}}/vendors/js/nice-select.min.js"></script>
			<style>
				/* The Modal (background) */
				.modal {
				display: none; /* Hidden by default */
				position: fixed; /* Stay in place */
				z-index: 1; /* Sit on top */
				padding-top: 10px; /* Location of the box */
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
			<script>
				if ($('.niceSelect').length) {
					$('.niceSelect').niceSelect();
				}
				$(document).ready(function () {
					
					$('#btnsubmit').on('click',function()
					{
						$(this).html('Please wait ...')
						.attr('disabled','disabled');
						$('#infix_form').submit();
					});
					
					
					$('select[name="student_category"]').on('change', function() {
						var selectedCategory = $(this).val();
						var durationSelect = $('select[name="duration"]');
						var durationOption = $(this).find('option:selected').data('duration');
						
						durationSelect.val(durationOption);
					});
					
				});
				
				
				$(document).ready(function() {
					$("#email-address").keyup(function(){
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
			
			
			function checkTermsConditions(){
			document.getElementById("term_and_conditions").checked = true;
			modal.style.display = "none";
			}
			
			function checkTermsConditionsFalse(){
			document.getElementById("term_and_conditions").checked = false;
			modal.style.display = "block";
			}
			</script>
			
			{!! Toastr::message() !!}
			</body>
			</html>
						