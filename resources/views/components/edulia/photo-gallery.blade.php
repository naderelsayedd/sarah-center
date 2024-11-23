<div class="section photo-gallery-section">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>معرض الصور</span></div></div></div>
		<div class="row mt-4">
			@if ($photoGalleries->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
			<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
			href="{{ URL::to('/photo-gallery') }}">@lang('edulia.photo_gallery')</a></p>
			@else
			<div class="col-12  wow fadeInUp">
				<div class="gallery-wrapper">
					@php
					$countup = 1;
					@endphp
					@foreach ($photoGalleries as $photoGallery)
					@php
					$count = 1;
					@endphp
					<div class="gallery-box">
						@foreach ($photoGallery->images as $images)
						<a href="{{$images->images}}"  data-fancybox="gallery{{ $countup }}" data-caption="{{$photoGallery->description}}" {{$count > 1 ? 'hidden' : ''}}>
							<img src="{{$images->images}}" class="w-100" alt="">
							<div class="gallery-caption">
								<div class="gallery-title">{{ $photoGallery->title }}</div>
								<div class="gallery-desc">{{$photoGallery->description}}</div>
							</div>
						</a>
						@php
						$count++;
						@endphp
						@endforeach
					</div>
					@php
						$countup++;
						@endphp
					@endforeach
				</div>
			</div>
			@endif
		</div>
		<div class="row mt-3">
			<div class="col-12">
				<div class="mt-4 text-center"><a class="theme-btn wow pulse" href="/photogallery">مشاهدة المزيد</a></div>
			</div>
		</div>
	</div>
</div>
