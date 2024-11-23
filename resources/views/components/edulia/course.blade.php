<div class="section courses-section">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>أهم الباقات</span></div></div></div>
		<div class="row mt-4 wow fadeInLeft">
			<div class="col-12 mt-3">
				<div id="courses-carousel" class="owl-carousel owl-theme wow fadeInRight">
					@if ($courses->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
					<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
					href="{{ URL::to('/course-list') }}">@lang('edulia.add_course')</a></p>
					@else
					@foreach ($course_category as $key => $category)
						    <?php
						        $routeMap = [
						            1 => 'onsite-nursery',
						            2 => 'onsite-kg',
						            3 => 'intensive-education-remedial',
						            4 => 'special-education',
						            5 => 'online-nursery',
						            6 => 'primary-stage',
						            7 => 'intermediate-stage',
						            8 => 'secondary-stage',
						            9 => 'undergraduate-stage',
						        ];

						        $route = $routeMap[$category->id] ?? ''; // default to empty string if ID not found
						    ?>
						    <div class="course-box">
						        <div class="course-img">
						            <a href="{{ URL('/'.$routeMap[$category->id]) }}"><img src="{{ asset($category->image) }}" class="w-100" alt=""></a>
						            <div class="course-category">{{ $category->mainCategory->category_name }}</div>
						        </div>
						        <div class="course-info">
						            <div class="course-title"><a href="{{ URL('/'.$routeMap[$category->id]) }}">{{ $category->category_name }}</a></div>
						            <div class="course-desc">
						                {{ implode(' ', array_slice(explode(' ', $category->description), 0, 50)) }}...
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


{{-- 
<div class="section courses-section">
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
							<div class="course-category">التعليم الحضوري</div>
							<a href="{{ URL::to('/register') }}/{{$course->class_id}}/{{$course->id}}" class="course-enroll"><i class="fas fa-user-plus"></i> التسجيل في الباقة</a>
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

--}}