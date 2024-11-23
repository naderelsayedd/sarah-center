<div class="section welcome-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 valign-center wow fadeInRight"><div class="welcome-img"> @if (!empty(pagesetting('home_about_area_image')))<img src="{{ pagesetting('home_about_area_image')[0]['thumbnail'] }}" class="w-100" alt="">@endif</div></div>
			<div class="col-lg-7 valign-center wow fadeInLeft">
				<div class="welcome-txt">
					<div class="heading"><span>{{ pagesetting('home_about_area_header') }}</span></div>
					<div class="welcome-p">
						<p>{!! pagesetting('home_about_area_description') !!}</p>
					</div>
					<div class="row advantages-wrapper">
						@if (!empty(pagesetting('home_about_area_items')))
						
                            @foreach (pagesetting('home_about_area_items') as $item)
							<div class="col-sm-6">
							<div class="advantage-box">{{ $item['item_heading'] }}</div>
							</div>
                            @endforeach
						
						@endif
						
					</div>
					<div class="mt-4"><a class="theme-btn" href="{{ pagesetting('home_about_area_button_link') }}">قراءة المزيد</a></div>
				</div>
			</div>
		</div>
	</div>
</div>