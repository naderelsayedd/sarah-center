<div class="section blog-section">
	<div class="container">
		<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>مقالاتنا</span></div></div></div>
		<div class="row">
			@if ($news->isEmpty() && auth()->check() && auth()->user()->role_id == 1)
			<p class="text-center text-danger">@lang('edulia.no_data_available_please_go_to') <a target="_blank"
			href="{{ URL::to('/news') }}">@lang('edulia.news')</a></p>
			@else
			@foreach ($news as $article)
			<div class="col-lg-6 mt-3 wow fadeInRight">
				<div class="course-box blog-box">
					<div class="course-img">
						<a href="{{ route('frontend.news-details', $article->id) }}"><img src="{{ asset($article->image) }}" class="w-100" alt=""></a>
					</div>
					<div class="course-info">
						<div class="blog-date">{{ dateConvert($article->publish_date) }} : التاريخ</div>
						<div class="course-title"><a href="{{ route('frontend.news-details', $article->id) }}">{{ $article->news_title }}</a></div>
						<div class="course-desc"> {{ $article->news_body}}</div>
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
		<div class="row mt-3">
			<div class="col-12">
				<div class="mt-4 text-center"><a class="theme-btn wow pulse" href="/news-list">قراءة المزيد</a></div>
			</div>
		</div>
	</div>
</div>

