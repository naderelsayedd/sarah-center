<div class="section notice-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="notice-board wow flipInX">
					<div class="notice-board-heading">لوحة الملاحظات</div>
					
					<div id="nt-example1-container">
						@if ($noticeBoards->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
						<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
						href="{{ URL::to('/notice-list') }}">@lang('edulia.notice_list')</a></p>
						@else
						
						<i class="fa fa-arrow-up" id="nt-example1-prev"></i>
						<ul id="nt-example1">
							@foreach ($noticeBoards as $notice)
							<li>
								<div class="notice-date"><div class="notice-day">{{ date('d', strtotime($notice->notice_date)) }}</div><div class="notice-month">{{ date('m', strtotime($notice->notice_date)) }}</div></div>
								<div class="notice-txt">
									<a class="notice-title" href="{{ route('frontend.notice-details', $notice->id) }}">{{ $notice->notice_title }}</a>
									<div class="notice-desc">{{ $notice->notice_message }}</div>
								</div>
							</li>
							@endforeach
							
						</ul>
						<i class="fa fa-arrow-down" id="nt-example1-next"></i>
						@endif
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>