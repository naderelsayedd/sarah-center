<div class="section teachers-section">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>المعلمين</span></div></div></div>
		<div class="row mt-4">
			@if ($teachers->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
			<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
			href="{{ URL::to('/expert-teacher') }}">@lang('edulia.teacher_list')</a></p>
			@else
			<div class="col-12 mt-3">
				<div id="teachers-carousel" class="owl-carousel owl-theme wow fadeInRight">
					@foreach ($teachers as $teacher)
					<div class="teachers-box">
						<div class="teachers-img"><img src="{{ asset(@$teacher->image) }}" class="w-100" alt=""></div>
						<div class="teachers-info">
							<div class="teachers-name">{{ $teacher->name }}</div>
							<div class="teachers-desc">{{ $teacher->designation }}</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

