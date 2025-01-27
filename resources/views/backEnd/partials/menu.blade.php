@php
$generalSetting = generalSetting();
$languages = systemLanguage();
$styles = userColorThemes();

@endphp

@php
$coltroller_role = 1;
@endphp

<style>
    .fas.fa-robot.menu-only {
	font-size: 20px;
	color: #828bb2;
	margin-right: 5px;
    }
	
    a.pulse.theme_color.bell_notification_clicker {
	margin-right: 15px !important;
    }
	
    @media (min-width: 1350px) {
	.header_middle {
	display: block !important;
	}
    }
</style>

<div class="container-fluid no-gutters" id="main-nav-for-chat">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="small_logo_crm d-lg-none">
                    <a href="#">
                        @if (!is_null($generalSetting->logo))
						<img src="{{ asset($generalSetting->logo) }}" alt="logo">
                        @else
						<img src="{{ asset('public/uploads/settings/logo.png') }}" alt="logo">
                        @endif
					</a>
				</div>
                <div id="sidebarCollapse" class="sidebar_icon  d-lg-none">
                    <i class="ti-menu"></i>
				</div>
                <div class="collaspe_icon open_miniSide">
                    <i class="ti-menu"></i>
				</div>
				
                <div class="serach_field-area ml-40">
                    <div class="search_inner">
                        <form action="#">
                            <div class="search_field">
                                <input type="text" class="form-control primary_input_field input-left-icon"
								placeholder="@lang('common.search')" id="search" onkeyup="showResult(this.value)">
							</div>
                            <button type="submit" style="padding-top: 3px"><i
							style="font-size: 13px; padding-left: 13px;" class="ti-search"></i></button>
						</form>
					</div>
                    <div id="livesearch" style="display: none;"></div>
				</div>
                <div class="header_middle d-none">
                    <div class="select_style d-flex">
                        @if (generalSetting()->website_btn == 1) @endif
						<a target="_blank" class="primary-btn white mr-10 tab_hide"
						href="{{ url('/') }}/home">@lang('common.website')</a>
						
                        @if (generalSetting()->dashboard_btn == 1)@endif
						@if (Auth::user()->role_id == $coltroller_role)@endif
						<a class="primary-btn white mr-10 tab_hide"
						href="{{ route('admin-dashboard') }}">@lang('common.dashboard')</a>
						
                        
                        @if (generalSetting()->report_btn == 1) @endif
						@if (Auth::user()->role_id == $coltroller_role) @endif
						<a class="primary-btn white mr-10 tab_hide"
						href="{{ route('reports') }}">@lang('reports.reports')</a>
						
						
                        {{-- <div class="border_1px tab_hide"></div> --}}
						
						
					</div>
				</div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="serach_field-area mr-10">
                        <div class="search_inner">
                            <div class="search_field">
                                <input type="text" class="form-control primary_input_field input-left-icon"
								placeholder="@lang('common.search')" id="searchStudent"
								onkeyup="showStudent(this.value)">
							</div>
                            <button type="submit" style="padding-top: 3px"><i
							style="font-size: 13px; padding-left: 13px;" class="ti-search"></i></button>
						</div>
                        <div id="liveStudentSearch" style="display: none;"></div>
					</div>
                    <!--<select name="#" class="nice_Select bgLess mb-0 infix_session" id="infix_session">
                        @foreach (academicYears() as $academic_year)
						@if (moduleStatusCheck('University'))
						<option value="{{ @$academic_year->id }}"
						{{ getAcademicId() == @$academic_year->id ? 'selected' : '' }}>
						{{ @$academic_year->name }} </option>
						@else
						<option value="{{ @$academic_year->id }}"
						{{ getAcademicId() == @$academic_year->id ? 'selected' : '' }}>
							{{ @$academic_year->year }} [{{ @$academic_year->title }}]
						</option>
						@endif
                        @endforeach
					</select>-->
					
                    @if (@$styles && Auth::user()->role_id == 1)
					@endif
					@if (generalSetting()->style_btn == 1)
					@endif
					<!--<select class="nice_Select bgLess mb-0 infix_theme_style" id="infix_theme_style">
						<option data-display="@lang('common.select_style')"
						value="0">@lang('common.select_style')
						</option>
						@foreach ($styles as $style)
						<option value="{{ $style->id }}"
						{{ color_theme()->id == $style->id ? 'selected' : '' }}>
							{{ $style->title }}
						</option>
						@endforeach
					</select>-->
					
                    @if (generalSetting()->lang_btn == 1) @endif
					<select class="nice_Select bgLess mb-0 languageChange" id="languageChange">
						<option data-display="@lang('common.select_language')"
						value="0">@lang('common.select_language')
						</option>
						@foreach ($languages as $lang)
						<option data-display="{{ $lang->native }}" value="{{ $lang->language_universal }}"
						{{ $lang->language_universal == userLanguage() ? 'selected' : '' }}>
						{{ $lang->native }}</option>
						@endforeach
					</select>
					
					
                    @if (moduleStatusCheck('AiContent'))
					@include('aicontent::inc.menu_btn')
                    @endif
					
                    <ul class="header_notification_warp d-flex align-items-center">
						
                        @if (app('general_settings')->get('chatting_method') == null || app('general_settings')->get('chatting_method') == 'log')
						<jquery-notification-component
						:unreads="{{ json_encode($notifications_for_chat) }}"
						:user_id="{{ json_encode(auth()->id()) }}"
						:redirect_url="{{ json_encode(route('chat.index')) }}"
						:check_new_notification_url="{{ json_encode(route('chat.notification.check')) }}"
						:asset_type="{{ json_encode(asset('/public')) }}"
						:mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}">
						</jquery-notification-component>
                        @else
						<notification-component
						:unreads="{{ json_encode($notifications_for_chat) }}"
						:user_id="{{ json_encode(auth()->id()) }}"
						:redirect_url="{{ json_encode(route('chat.index')) }}"
						:asset_type="{{ json_encode(asset('/public')) }}"
						:mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}">
						</notification-component>
                        @endif
                        {{-- Start Notification --}}
                        <li class="scroll_notification_list">
                            <a class="pulse theme_color bell_notification_clicker show_notifications" href="#">
                                <!-- bell   -->
                                <i class="fa fa-bell"></i>
								
                                <!--/ bell   -->
                                <span
								class="notificationCount notification_count">{{ count($notifications ?? []) }}</span>
                                <span class="pulse-ring notification_count_pulse"></span>
							</a>
                            <!-- Menu_NOtification_Wrap  -->
                            <div class="Menu_NOtification_Wrap notifications_wrap">
                                <div class="notification_Header">
                                    <h4>{{ __('common.no_unread_notification') }}</h4>
								</div>
                                <div class="Notification_body">
                                    <!-- single_notify  -->
                                    @forelse ($notifications as $notification)
									<div class="single_notify d-flex align-items-center"
									id="menu_notification_show_{{ $notification->id }}">
										<div class="notify_thumb">
											<i class="fa fa-bell"></i>
										</div>
										@if(!empty($notification->url))
										<a href="/{{ $notification->url }}" class="unread_notification" title="Mark As Read" data-notification_id="{{ $notification->id }}">
											<div class="notify_content">
												<h5>{{ date('h.i a', strtotime($notification->created_at)) }}</h5>
												<p>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->message, 70, $end = '...')) !!}</p>
											</div>
										</a>										  
										@else
										<a href="{{ route('notification-show', $notification->id) }}" class="unread_notification" title="Mark As Read" data-notification_id="{{ $notification->id }}">
											<div class="notify_content">
												<h5>{{ date('h.i a', strtotime($notification->created_at)) }}</h5>
												<p>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->message, 70, $end = '...')) !!}</p>
											</div>
										</a>
										@endif
									</div>
                                    @empty
									<span class="text-center">{{ __('common.no_unread_notification') }}</span>
                                    @endforelse
									
								</div>
                                <div class="nofity_footer">
                                    <div class="submit_button text-center pt_20">
                                        {{-- <a href=""
										class="primary-btn radius_30px text_white  fix-gr-bg">{{__('common.See More')}}</a>
                                        --}}
                                        <a href="{{ route('view/all/notification', Auth()->user()->id) }}"
										class="primary-btn radius_30px text_white  fix-gr-bg mark-all-as-read">{{ __('common.mark_all_as_read') }}</a>
									</div>
								</div>
							</div>
                            <!--/ Menu_NOtification_Wrap  -->
						</li>
                        {{-- End Notification --}}
						
						
					</ul>
                    <div class="profile_info">
						
                        <div class="user_avatar_div">
                            <img id="profile_pic"
							src="{{ @profile() && file_exists(@profile()) ? asset(profile()) : asset('public/backEnd/assets/img/avatar.png') }}"
							alt="">
						</div>
						
                        <div class="profile_info_iner">
                            <p> {{ Auth::user()->email }}</p>
                            <h5>{{ Auth::user()->full_name }} @if (isset(Auth::user()->wallet_balance))
								@if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
								<p class="message">
									<strong>
										@lang('common.balance'):
										{{ Auth::user()->wallet_balance != null ? currency_format(Auth::user()->wallet_balance) : currency_format(0.0) }}
									</strong>
								</p>
								@endif
                                @endif
							</h5>
                            <div class="profile_info_details">
                                @if (Auth::user()->is_saas == 1)
								<a href="{{ route('saasStaffDashboard') }}">
									
									@lang('common.saas_dashboard')
									<span class="fa fa-home"></span>
								</a>
                                @endif
                                @if (Auth::user()->role_id == '2' && Auth::user()->is_saas == 0)
								<a href="{{ route('student-profile') }}">
									
									@lang('common.view_profile')
									<span class="ti-user"></span>
								</a>
                                @elseif(Auth::user()->role_id != '3' && Auth::user()->is_saas == 0 && Auth::user()->staff)
								<a href="{{ route('viewStaff', Auth::user()->staff->id) }}">
									
									@lang('common.view_profile')
									<span class="ti-user"></span>
								</a>
                                @endif
                                @if (config('app.app_sync') && auth()->user()->role_id != 1)
								@if (auth()->user()->staff && auth()->user()->staff->parent_id && auth()->user()->role_id == 3)
								<a href="{{ route('viewAsRole') }}">
									
									@lang('common.VIEW_AS_' . strtoupper(auth()->user()->staff->previousRole->name))
									<span style="margin-left: 3px;" class="ti-key"></span>
								</a>
								@elseif(auth()->user()->staff && auth()->user()->staff->parent_id)
								<a href="{{ route('viewAsParent') }}">
									
									@lang('common.VIEW_AS_PARENT')
									<span style="margin-left: 3px;" class="ti-key"></span>
								</a>
								@endif
                                @endif
                                @if (moduleStatusCheck('Saas') == true &&
								Auth::user()->is_administrator == 'yes' &&
								Auth::user()->role_id == 1 &&
								Auth::user()->is_saas == 0)
								
								<a href="{{ route('viewAsSuperadmin') }}">
									
									@if (Session::get('isSchoolAdmin') == true)
									@lang('common.view_as_saas_admin')
									@else
									@lang('common.view_as_school_admin')
									@endif
									<span style="margin-left: 3px;" class="ti-key"></span>
								</a>
                                @endif
                                <a href="{{ route('updatePassowrd') }}">
									
                                    @lang('common.password')<span style="margin-left: 3px;" class="ti-key"></span>
								</a>
								
								
                                <a href="{{ Auth::user()->role_id == 2 ? route('student-logout') : route('logout') }}"
								onclick="event.preventDefault();
								
								document.getElementById('logout-form').submit();">
									
                                    @lang('common.logout')
                                    <span class="ti-unlock"></span>
								</a>
								
                                <form id="logout-form"
								action="{{ Auth::user()->role_id == 2 ? route('student-logout') : route('logout') }}"
								method="POST" class="d-none">
									
                                    @csrf
								</form>
							</div>
							<div class="color-themes">
								<ul>
									<li><span class="color-option" id="white-theme" title="White"></span></li>
									<li><span class="color-option" id="blueblack-theme" title="Blueblack"></span></li>
									<li><span class="color-option" id="dark-orange-theme" title="Orange Dark"></span></li>
									<li><span class="color-option" id="light-orange-theme" title="Orange Light"></span></li>
									<li><span class="color-option" id="dark-blue-theme" title="Orange Light"></span></li>
									<li><span class="color-option" id="light-blue-theme" title="Light Blue"></span></li>
									<li><span class="color-option" id="cyan-theme" title="Cyan"></span></li>
									<li><span class="color-option" id="green-theme" title="Green"></span></li>
									<li><span class="color-option" id="brightblue-theme" title="Bright Blue"></span></li>
									<li><span class="color-option" id="purple-theme" title="Purple"></span></li>
									<li><span class="color-option" id="darkblueblack-theme" title="Dark Blueblack"></span></li>
									<li><span class="color-option" id="darkred-theme" title="Dark Red"></span></li>
									<li><span class="color-option" id="turkishaqua-theme" title="Turkish Aqua"></span></li>
									<li><span class="color-option" id="barared-theme" title="Bara Red"></span></li>
									<li><span class="color-option" id="magentapurple-theme" title="Magenta Purple"></span></li>
									<li><span class="color-option" id="greycyan-theme" title="Grey Cyan"></span></li>
									<li><span class="color-option" id="greyorange-theme" title="Grey Orange"></span></li>
									<li><span class="color-option" id="midnightblue-theme" title="Midnight Blue"></span></li>
									<li><span class="color-option" id="green-beige-theme" title="Green Beige"></span></li>
									<li><span class="color-option" id="navy-teal-theme" title="Navy Teal"></span></li>
								</ul>
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@if (moduleStatusCheck('AiContent'))
@include('aicontent::content_generator_modal')
@endif

@if (moduleStatusCheck('WhatsappSupport'))
@include('whatsappsupport::partials._popup')
@endif


@section('script')
@endsection
