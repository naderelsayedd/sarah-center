<div class="section videos-section bg-styles">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>معرض الفيديوهات</span></div></div></div>
		<div class="row mt-4 wow fadeInUp">
			@if ($videoGalleries->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
			<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
			href="{{ URL::to('/video-gallery') }}">@lang('edulia.video_gallery')</a></p>
			@else
			@php
			$count = 1;
			@endphp
			@foreach ($videoGalleries as $videoGallery)
			@php
			$variable = substr($videoGallery->video_link, 32, 11);
			
			@endphp
			<div class="col-lg-4 mt-3">
				<div class="video-gallery-box gallery-box">
					<a href="https://www.youtube.com/watch?v={{ $variable }}" data-fancybox="video-gallery1" data-caption="{{$videoGallery->description}}">
						<img src="https://img.youtube.com/vi/{{ $variable }}/maxresdefault.jpg" class="w-100" alt="">
						<div class="gallery-caption">
							<div class="gallery-title">{{$videoGallery->name}}</div>
							<div class="gallery-desc">{{$videoGallery->description}}</div>
						</div>
					</a>
					
				</div>
			</div>
			@php
			$count++;
			@endphp
			@endforeach
			@endif
		</div>
		<div class="row mt-3">
			<div class="col-12">
				<div class="mt-4 text-center"><a class="theme-btn wow pulse" href="/videogallery">مشاهدة المزيد</a></div>
			</div>
		</div>
	</div>
</div>

