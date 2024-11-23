<div class="cta-section">
  <div class="container">
    <div class="row">
      <div class="col-12 wow flipInX">
        <div class="cta">
          <div class="cta-img">@if (!empty(pagesetting('counter_image'))) <img src="{{pagesetting('counter_image')[0]['thumbnail']}}" class="w-100" alt=""> @endif</div>
          <div class="cta-txt">
            <div class="row">
              <div class="col-8">
                <div class="cta-title">{!! pagesetting('counter_description') !!}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="counters-section">
	<div class="container">
		<div class="row">
			@if (!empty(pagesetting('counter_list_items')))
			@foreach (pagesetting('counter_list_items') as $item)
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="counter-box">
					<h1><span class="counter with-plus">{{ $item['item_number'] }}</span></h1>
					<h3>{{ $item['item_heading'] }}</h3>
				</div>
			</div>
			@endforeach
			@endif
			
		</div>
	</div>
</div>


<!-- funfact area start -->

