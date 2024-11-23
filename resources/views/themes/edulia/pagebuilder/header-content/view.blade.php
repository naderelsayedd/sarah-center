
@php
$generalSetting = generalSetting();
$is_registration_permission = false;
$courses = App\SmCourse::where('school_id', $generalSetting->school_id)->get();
if (moduleStatusCheck('ParentRegistration')) {
$reg_setting = Modules\ParentRegistration\Entities\SmRegistrationSetting::where('school_id', $generalSetting->school_id)->first();
$is_registration_position = $reg_setting ? $reg_setting->position : null;
$is_registration_permission = $reg_setting ? $reg_setting->registration_permission == 1 : false;
}
@endphp
<div class="top-bar">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="top-bar-social">
					<ul>
						@if (!empty(pagesetting('header-right-menus')))
						@foreach (pagesetting('header-right-menus') as $icon)
						<li>
							<a href="{{ gv($icon, 'header-right-icon-url') }}">
								<i class="{{ gv($icon, 'header-right-icon-class') }}"></i>
								{{ gv($icon, 'header-right-menu-label') }}
							</a>
						</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
			
			<div class="col-lg-6">
				<div class="top-bar-content text-right">
					@if (!empty(pagesetting('header-left-menus')))
					@foreach(pagesetting('header-left-menus') as $rightMenu)
					<div class="top-contact">
						<a href="{{ gv($rightMenu, 'header-left-menu-icon-url') }}">
							<i class="{{gv($rightMenu, 'header-left-menu-icon-class')}}"></i>
							{{ gv($rightMenu, 'header-left-menu-label') }}
						</a>
					</div>
					@endforeach
					@endif
					<div class="top-contact">
						@if (!auth()->check())
						<a href="{{url('/login')}}">
						<i class="far fa-user"></i>
						{{ __('edulia.login')}}
					</a>
					@else
					<a href="{{url('/admin-dashboard')}}">
						<i class="far fa-user"></i>
						{{ __('edulia.dashboard')}}
					</a>
					@endif
					</div>
					@if (!auth()->check())
					<div class="top-contact">
						
						<a href="javascript:void(0);" id="myBtn">
							<i class="far fa-user"></i>
							{{ __('edulia.register')}}
						</a>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="nav-con">
	<nav class="navbar navbar-expand-xl">
		<div class="container">
			<a class="navbar-brand" href="/"><img src="{{pagesetting('header_menu_image') ? pagesetting('header_menu_image')[0]['thumbnail'] : defaultLogo($generalSetting->logo) }}" alt=""></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<!-- <span class="navbar-toggler-icon"></span> -->
				<i class="fa-solid fa-bars"></i>
			</button>
			<x-header-content-menu></x-header-content-menu>
		</div>
	</nav>
</div>
