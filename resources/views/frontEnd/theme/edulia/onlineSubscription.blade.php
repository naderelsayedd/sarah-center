@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@php
$gs = generalSetting();
@endphp
<!-- about area start -->
@if($courseCategory)
<div class="inner-header bg-styles" style="background-image: url({{asset(@$courseCategory->category_image)}});">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="inner-title">{{$courseCategory->category_name}}</div>
				<p>{!! $courseCategory->description !!}</p>
			</div>
		</div>
	</div>
</div>


<div class="section welcome-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 valign-center wow fadeInRight"><div class="welcome-img"><img src="{{asset(@$category->image)}}" class="w-100" alt=""></div></div>
			<div class="col-lg-7 valign-center wow fadeInLeft">
				<div class="welcome-txt">
					<h2>{{$category->category_name}}:</h2>
					<div class="description">{!! $category->description !!}</div>
					<div class="welcome-p">
						{!! $category->details !!}
					</div>
				</div>
			</div>
		</div>
		@if($subscriptionWithOutOffer->isNotEmpty())
		<div class="row mt-4">
			<h2>أنظمة الاشتراك</h2>
			<div class="row advantages-wrapper">
				@foreach($subscriptionWithOutOffer as $subscriptons)
				<div class="col-sm-6">
					<div class="advantage-box package-box">
						<span>{{$subscriptons->name}}</span>
						<a href="{{ route('register', ['subscription_id' => encrypt($subscriptons->id), 'course_id' => encrypt(1)]) }}">{{ $subscriptons->price }} ريال</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
		@if($subscriptionWithOffer->isNotEmpty())
		<div class="row mt-4">
			<div class="col-lg-12">
				<div class="offers-box">
					
					<h2>@lang('subscription.offer')</h2>
					<div class="row advantages-wrapper">
						
						@foreach($subscriptionWithOffer as $subscriptons)
						<div class="col-sm-6">
							<div class="advantage-box package-box">
								<span>{{$subscriptons->name}}</span>
								<a href="{{ route('register', ['subscription_id' => encrypt($subscriptons->id), 'course_id' => encrypt(1)]) }}">{{$subscriptons->price}} ريال</a>
							</div>
						</div>
						@endforeach
						
					</div>
					
				</div>
			</div>
		</div>
		@endif
		@if($subscriptionType1->isNotEmpty())
		<div class="row mt-4">
			<div class="col-lg-12">
				<div class="offers-box">
					
					<h2>@lang('subscription.offer_type_1')</h2>
					<div class="row advantages-wrapper">
						
						@foreach($subscriptionType1 as $subscriptons)
						<div class="col-sm-6">
							<div class="advantage-box package-box">
								<span>{{$subscriptons->name}}</span>
								<a href="{{ route('register', ['subscription_id' => encrypt($subscriptons->id), 'course_id' => encrypt(1)]) }}">{{$subscriptons->price}} ريال</a>
							</div>
						</div>
						@endforeach
						
					</div>
					
				</div>
			</div>
		</div>
		@endif
		
		@if($subscriptionType2->isNotEmpty())
		<div class="row mt-4">
			<div class="col-lg-12">
				<div class="offers-box">
					
					<h2>@lang('subscription.offer_type_2')</h2>
					<div class="row advantages-wrapper">
						
						@foreach($subscriptionType2 as $subscriptons)
						<div class="col-sm-6">
							<div class="advantage-box package-box">
								<span>{{$subscriptons->name}}</span>
								<a href="{{ route('register', ['subscription_id' => encrypt($subscriptons->id), 'course_id' => encrypt(1)]) }}">{{$subscriptons->price}} ريال</a>
							</div>
						</div>
						@endforeach
						
					</div>
					
				</div>
			</div>
		</div>
		@endif
	</div>
</div>  
@endif
{{footerContent()}}
