@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@section(config('pagebuilder.site_section'))
@php
    $gs = generalSetting();
@endphp
<div class="">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>أهم الباقات</span></div></div></div>
		<div class="row mt-4 wow fadeInLeft">
			<div class="col-12 mt-3">
				<div id="courses-carousel" class="owl-carousel owl-theme wow fadeInRight">
					@if ($courses->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
					<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
					href="{{ URL::to('/course-list') }}">@lang('edulia.add_course')</a></p>
					@else
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
					<div class="course-box">
						<div class="course-img">
							<a href="{{ route('frontend.course-details', $course->id) }}"><img src="{{ asset($course->image) }}" class="w-100" alt=""></a>
							<div class="course-category">
								@if($course->courseCategory->category_name)  
								{{ $course->courseCategory->category_name }}
								@endif 
							</div>
							<a href="{{ URL::to('/register') }}/{{$course->class_id}}/{{$course->id}}" class="course-enroll"><i class="fas fa-user-plus"></i>
								@if($course->sectionClass->category_name)  
									({{ $course->sectionClass->category_name }}) 
								@endif 
								التسجيل في الباقة
							</a>
						</div>
						<div class="course-info">
							<div class="course-title"><a href="#">{{ $course->title }}</a></div>
							<div class="course-desc">
								@if($course->courseClass->class_name)  
								{{ $course->courseClass->class_name }}
								@endif 
							</div>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
{{footerContent()}}
@endsection