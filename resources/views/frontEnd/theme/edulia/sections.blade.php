@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@section(config('pagebuilder.site_section'))
@php
    $gs = generalSetting();
@endphp
<div class="">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>الأقسام</span></div></div></div>
		<div class="row mt-4 wow fadeInLeft">
			<div class="col-12 mt-3">
				<div id="courses-carousel" class="owl-carousel owl-theme wow fadeInRight">
					@if ($sections)
					@foreach ($sections as $key => $section)
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
							<a href="{{ route('frontend.section-details', $section->id) }}"><img src="{{ asset($section->image) }}" class="w-100" alt=""></a>
							<div class="course-category">{{ $section->category_name }}</div>
							<a href="{{ route('frontend.section-details', $section->id) }}" class="course-enroll"><i class="fas fa-user-plus"></i> حدد الدورة التدريبية</a>
						</div>
						<div class="course-info">
							<div class="course-title"><a href="{{ route('frontend.section-details', $section->id) }}">{{ $section->category_name }}</a></div>
							<div class="course-desc">
								@if($section->description)  
								{{ $section->description }}
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