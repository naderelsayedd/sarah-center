@php
$setting = generalSetting();
App::setLocale(getUserLanguage());
$ttl_rtl = userRtlLtl();
@endphp

<!doctype html>
<html lang="ar" dir="rtl" class="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="{{ asset($setting->favicon) }}" type="image/png" />
		<title>{{ $setting->site_title ? $setting->site_title : 'Sara Center' }} | {{(@$page) ? @$page->title : __('common.home')}}</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="_token" content="{!! csrf_token() !!}" />
		@if (!empty($page->description) )
		<meta name="description" content="{{ $page->description }}" />
		@endif
		
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/bootstrap/bootstrap.min.css') }}" type="text/css">
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/call-styles.css') }}" type="text/css">
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/fontawesome.min.css') }}">
		
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="{{ asset('public/theme/'.activeTheme().'/include/css/jquery.fancybox.min.css') }}">
		
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/animate.css') }}">
		
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/theme/'.activeTheme().'/include/css/owl.theme.default.min.css') }}">
		
		<script src="{{ asset('public/theme/'.activeTheme().'/include/js/wow.min.js') }}"></script>
		<script>new WOW().init();</script>
	</head>
	<body>
		
		@yield(config('pagebuilder.site_section'))

        <script>
            window._locale = 'ar';
            window._rtl = true;
		</script>
       

        
		
		
		
		<script src="{{ asset('public/theme/'.activeTheme().'/include/js/jquery-3.6.0.min.js') }}"></script>
		<script src="{{ asset('public/theme/'.activeTheme().'/include/js/bootstrap.bundle.min.js') }}"></script>
		
		<script>
			/*SCROLL PAGE TO TOP*/
			$(document).ready(function() {
				$(window).scroll(function(){
					if($(window).scrollTop() > 0){$(".toTop").fadeIn("slow");} else {$(".toTop").fadeOut("slow");}
				});
				if($(".toTop").length > 0) {
					$(".toTop").click(function(){
						event.preventDefault();
						$("html, body").animate({scrollTop:0},"slow");
					});
				}
			});
		</script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js"></script>
		<script>
			if($(".carousel").length > 0) {
				$(".carousel").swipe({
					swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
						if (direction == 'left') $(this).carousel('next');
						if (direction == 'right') $(this).carousel('prev');
					},
					allowPageScroll: "vertical" 
				});
			}
		</script>
		
		<script src="{{ asset('public/theme/'.activeTheme().'/include/js/jquery.fancybox.min.js') }}"></script>
		<script>
			if($("[data-fancybox]").length > 0) {
				$("[data-fancybox]").fancybox({
					buttons: [
					"zoom",
					"share",
					"slideShow",
					"fullScreen",
					// "download",
					"thumbs",
					"close"
					],
					loop: true,
				});
			}
		</script>
		
		<script src="{{ asset('public/theme/'.activeTheme().'/include/js/owl.carousel.js') }}"></script>
		<script>
			$(document).ready(function(){
				if($("#teachers-carousel").length > 0) {
					$("#teachers-carousel").owlCarousel({
						margin:30,
						autoplay:true,
						loop:true,
						rtl:true,
						autoplayHoverPause:true,
						responsive:{ 0:{items:1,}, 600:{items:2,}, 900:{items:3,}, 1200:{items:4,} }
					});
				}
				if($("#courses-carousel").length > 0) {
					$("#courses-carousel").owlCarousel({
						margin:20,
						loop: true,
						autoplay: true,
						rtl: true,
						autoplayHoverPause:true,
						responsive:{0:{ items:1, }, 768:{ items:3, }, 1000:{ items:3, } }
					});
				}
				if($("#testimonials-carousel").length > 0) {
					$("#testimonials-carousel").owlCarousel({
						margin: 0,
						center: true,
						loop: true,
						autoplay: true,
						rtl: true,
						autoplayHoverPause:true,
						responsive:{0:{ items:1, }, 768:{ items:3, }, 1000:{ items:3, } }
					});
				}
			});
		</script>
		
		<script type="text/javascript" src="{{ asset('public/theme/'.activeTheme().'/include/js/jquery.newsTicker.js') }}"></script>
		<script>
			if($('#nt-example1').length > 0) {
				var nt_example1 = $('#nt-example1').newsTicker({
					row_height: 90,
					max_rows: 3,
					duration: 4000,
					prevButton: $('#nt-example1-prev'),
					nextButton: $('#nt-example1-next')
				});
			}
		</script>
		
		
		<script type="text/javascript" src="{{ asset('public/theme/'.activeTheme().'/include/js/waypoints.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('public/theme/'.activeTheme().'/include/js/jquery.counterup.min.js') }}"></script>
		<script>
			if($('.counter').length > 0) {
				$('.counter').counterUp({
					delay: 10,
					time: 2000
				});
				$('.counter').addClass('animated fadeInDownBig');
			}
			if($('h3').length > 0) {
				$('h3').addClass('animated fadeIn');
			}
		</script>
		@stack(config('pagebuilder.script_var'))  
	</body>
</html>

