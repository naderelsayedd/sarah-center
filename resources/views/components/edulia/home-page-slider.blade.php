<div class="fold-area">
  <div class="slider-con  wow fadeIn">
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
				@php
				$count = 1;
				@endphp
				@foreach($homeSliders as $homeSlider)
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count - 1}}" class="{{$count == 1 ? 'active' : ''}}" aria-current="true" aria-label="Slide {{$count}}">{{$count}}</button>
				@php
				$count++;
				@endphp
				@endforeach
				
			</div>
			<div class="carousel-inner">
			@php
				$count = 1;
				@endphp
				@foreach ($homeSliders as $homeSlider)
				<div class="carousel-item bg-styles {{$count == 1 ? 'active' : ''}}" style="background-image:url('{{ asset($homeSlider->image) }}');">
					<div class="container">
						<div class="col-lg-12">
							<div class="slide-content">
								<div class="slider-txt animated fadeInUp" data-wow-delay=".3s">
									اصنع عبقري المستقبل <br>
									<span>اكتشف معنا عالم التعليم الترفيهي</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				@php
				$count++;
				@endphp
				@endforeach
			</div>
			 <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
		</div>
	</div>
</div>
