@extends('backEnd.master')
@section('title')
@lang('hr.edit_staff')
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backEnd/') }}/css/croppie.css">
@endsection
@section('mainContent')
<style type="text/css">
	.form-control:disabled {
	background-color: #FFFFFF;
	}
	.ti-calendar:before {
	position: relative;
	bottom: 8px;
	}
	
	.input-right-icon button.primary-btn-small-input {
	top: 66% !important;
	right: 11px !important;
	}
</style>
<input type="text" hidden id="urlStaff" value="{{ route('staffProfileUpdate', $editData->id) }}">
<section class="sms-breadcrumb mb-40 white-box">
	<div class="container-fluid">
		<div class="row justify-content-between">
			<h1>@lang('hr.edit_staff')</h1>
			<div class="bc-pages">
				<a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
				<a href="{{route('staff_directory')}}">@lang('hr.staff_list')</a>
				<a href="{{route('editStaff', $editData->id)}}">@lang('hr.edit_staff')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-6">
				<div class="main-title">
					<h3 class="mb-30">@lang('hr.edit_staff')</h3>
				</div>
			</div>
		</div>
		@if(Illuminate\Support\Facades\Config::get('app.app_sync'))
		{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admin-dashboard', 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
		@else
		{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'staffUpdate', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
		@endif
		<div class="row">
			<div class="col-lg-12">
				<div class="white-box">
					<div class="">
						<div class="row">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.basic_info')</h4>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						
						<input type="hidden" name="staff_id" value="{{ @$editData->id }}" id="_id">
						<div class="row mb-30 mt-20" >
							@if (in_array('staff_no', $has_permission))
							<div class="col-lg-3" style="display:none;">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.staff_number')
									{{ in_array('staff_no', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('staff_no') ? ' is-invalid' : '' }}"
									type="text" name="staff_no" readonly value="@if (isset($editData)){{ $editData->staff_no }} @endif">
									
									
									@if ($errors->has('staff_no'))
									<span class="text-danger" >
										{{ $errors->first('staff_no') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('first_name', $has_permission))     
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.first_name') {{ in_array('first_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
									type="text" name="first_name" value="@if (isset($editData)){{ $editData->first_name }} @endif @if (isset($editData)){{ $editData->last_name }}@endif">
									
									
									@if ($errors->has('first_name'))
									<span class="text-danger" >
										{{ $errors->first('first_name') }}
									</span>
									@endif
								</div>
							</div>
							@endif    
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.age') {{ in_array('age', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('age') ? ' is-invalid' : '' }}"
									type="text" name="age" value="@if (isset($editData)){{ $editData->age }} @endif">
									
									
									@if ($errors->has('age'))
									<span class="text-danger" >
										{{ $errors->first('age') }}
									</span>
									@endif
								</div>
							</div>
							@if (in_array('role', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.role')
									{{ in_array('role', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
									name="role_id" id="role_id">
										@if ($editData->role_id != 1)
										<option
										data-display="@lang('hr.role') {{ in_array('role', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('role', $is_required) ? '*' : '' }}</option>
										
										@foreach ($roles as $key => $value)
										<option value="{{ $value->id }}" @if (isset($editData))
										@if (($editData->role_id==3 ? $editData->previous_role_id :$editData->role_id) == $value->id)
											selected
											@endif
											@endif
										>{{ $value->name }}</option>
										@endforeach
										@else
										
										<option value="1">Superadmin</option>
										
										@endif
									</select>
									
									@if ($errors->has('role_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('role_id') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('department', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.department')
									{{ in_array('department', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}"
									name="department_id" id="department_id">
										<option
										data-display="@lang('hr.department') {{ in_array('department', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('department', $is_required) ? '*' : '' }}</option>
										@foreach ($departments as $key => $value)
										<option value="{{ $value->id }}" @if (isset($editData))
										@if ($editData->department_id == $value->id)
											selected
											@endif
											@endif
										>{{ $value->name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('department_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('department_id') }}
									</span>
									@endif
								</div>
							</div>
							@endif 
							@if (in_array('designation', $has_permission))   
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.designation')
									{{ in_array('designation', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('designation_id') ? ' is-invalid' : '' }}"
									name="designation_id" id="designation_id">
										<option
										data-display="@lang('hr.designation') {{ in_array('designation', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('designation', $is_required) ? '*' : '' }}</option>
										@foreach ($designations as $key => $value)
										<option value="{{ $value->id }}" @if (isset($editData))
										@if ($editData->designation_id == $value->id)
											selected
											@endif
											@endif
										>{{ $value->title }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('designation_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('designation_id') }}
									</span>
									@endif
								</div>
							</div>
							@endif
						</div>
						
						<div class="row mb-30">
							
							@if (in_array('last_name', $has_permission))  
							<div class="col-lg-3" style="display:none;">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.last_name') {{ in_array('last_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
									type="text" name="last_name" value="@if (isset($editData)){{ $editData->last_name }}@endif">
									
									
									@if ($errors->has('last_name'))
									<span class="text-danger" >
										{{ $errors->first('last_name') }}
									</span>
									@endif
								</div>
							</div>
							@endif 
							@if (in_array('gender', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.gender')
									{{ in_array('gender', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('gender_id') ? ' is-invalid' : '' }}"
									name="gender_id">
										<option
										data-display="@lang('common.gender') {{ in_array('gender', $is_required) ? '*' : '' }}"
										value="">@lang('common.gender') {{ in_array('gender', $is_required) ? '*' : '' }}
										</option>
										@foreach ($genders as $gender)
										<option value="{{ $gender->id }}" @if (isset($editData))
										@if ($editData->gender_id == $gender->id)
											selected
											@endif
											@endif
										>{{ $gender->base_setup_name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('gender_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('gender_id') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.nationality')
									{{ in_array('nationality', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="nationality" onchange="nationalityChange(this.value)">
										<option
										data-display="@lang('common.nationality') {{ in_array('nationality', $is_required) ? '*' : '' }}"
										value="">@lang('common.nationality')
										{{ in_array('nationality', $is_required) ? '*' : '' }}</option>
										
										<option {{ $editData->nationality == 'afghan' ? 'selected' : '' }} value="afghan">Afghan</option>
										<option {{ $editData->nationality == 'albanian' ? 'selected' : '' }} value="albanian">Albanian</option>
										<option {{ $editData->nationality == 'algerian' ? 'selected' : '' }} value="algerian">Algerian</option>
										<option {{ $editData->nationality == 'american' ? 'selected' : '' }} value="american">American</option>
										<option {{ $editData->nationality == 'andorran' ? 'selected' : '' }} value="andorran">Andorran</option>
										<option {{ $editData->nationality == 'angolan' ? 'selected' : '' }} value="angolan">Angolan</option>
										<option {{ $editData->nationality == 'antiguans' ? 'selected' : '' }} value="antiguans">Antiguans</option>
										<option {{ $editData->nationality == 'argentinean' ? 'selected' : '' }} value="argentinean">Argentinean</option>
										<option {{ $editData->nationality == 'armenian' ? 'selected' : '' }} value="armenian">Armenian</option>
										<option {{ $editData->nationality == 'australian' ? 'selected' : '' }} value="australian">Australian</option>
										<option {{ $editData->nationality == 'austrian' ? 'selected' : '' }} value="austrian">Austrian</option>
										<option {{ $editData->nationality == 'azerbaijani' ? 'selected' : '' }} value="azerbaijani">Azerbaijani</option>
										<option {{ $editData->nationality == 'bahamian' ? 'selected' : '' }} value="bahamian">Bahamian</option>
										<option {{ $editData->nationality == 'bahraini' ? 'selected' : '' }} value="bahraini">Bahraini</option>
										<option {{ $editData->nationality == 'bangladeshi' ? 'selected' : '' }} value="bangladeshi">Bangladeshi</option>
										<option {{ $editData->nationality == 'barbadian' ? 'selected' : '' }} value="barbadian">Barbadian</option>
										<option {{ $editData->nationality == 'barbudans' ? 'selected' : '' }} value="barbudans">Barbudans</option>
										<option {{ $editData->nationality == 'batswana' ? 'selected' : '' }} value="batswana">Batswana</option>
										<option {{ $editData->nationality == 'belarusian' ? 'selected' : '' }} value="belarusian">Belarusian</option>
										<option {{ $editData->nationality == 'belgian' ? 'selected' : '' }} value="belgian">Belgian</option>
										<option {{ $editData->nationality == 'belizean' ? 'selected' : '' }} value="belizean">Belizean</option>
										<option {{ $editData->nationality == 'beninese' ? 'selected' : '' }} value="beninese">Beninese</option>
										<option {{ $editData->nationality == 'bhutanese' ? 'selected' : '' }} value="bhutanese">Bhutanese</option>
										<option {{ $editData->nationality == 'bolivian' ? 'selected' : '' }} value="bolivian">Bolivian</option>
										<option {{ $editData->nationality == 'bosnian' ? 'selected' : '' }} value="bosnian">Bosnian</option>
										<option {{ $editData->nationality == 'brazilian' ? 'selected' : '' }} value="brazilian">Brazilian</option>
										<option {{ $editData->nationality == 'british' ? 'selected' : '' }} value="british">British</option>
										<option {{ $editData->nationality == 'bruneian' ? 'selected' : '' }} value="bruneian">Bruneian</option>
										<option {{ $editData->nationality == 'bulgarian' ? 'selected' : '' }} value="bulgarian">Bulgarian</option>
										<option {{ $editData->nationality == 'burkinabe' ? 'selected' : '' }} value="burkinabe">Burkinabe</option>
										<option {{ $editData->nationality == 'burmese' ? 'selected' : '' }} value="burmese">Burmese</option>
										<option {{ $editData->nationality == 'burundian' ? 'selected' : '' }} value="burundian">Burundian</option>
										<option {{ $editData->nationality == 'cambodian' ? 'selected' : '' }} value="cambodian">Cambodian</option>
										<option {{ $editData->nationality == 'cameroonian' ? 'selected' : '' }} value="cameroonian">Cameroonian</option>
										<option {{ $editData->nationality == 'canadian' ? 'selected' : '' }} value="canadian">Canadian</option>
										<option {{ $editData->nationality == 'cape verdean' ? 'selected' : '' }} value="cape verdean">Cape Verdean</option>
										<option {{ $editData->nationality == 'central african' ? 'selected' : '' }} value="central african">Central African</option>
										<option {{ $editData->nationality == 'chadian' ? 'selected' : '' }} value="chadian">Chadian</option>
										<option {{ $editData->nationality == 'chilean' ? 'selected' : '' }} value="chilean">Chilean</option>
										<option {{ $editData->nationality == 'chinese' ? 'selected' : '' }} value="chinese">Chinese</option>
										<option {{ $editData->nationality == 'colombian' ? 'selected' : '' }} value="colombian">Colombian</option>
										<option {{ $editData->nationality == 'comoran' ? 'selected' : '' }} value="comoran">Comoran</option>
										<option {{ $editData->nationality == 'congolese' ? 'selected' : '' }} value="congolese">Congolese</option>
										<option {{ $editData->nationality == 'costa rican' ? 'selected' : '' }} value="costa rican">Costa Rican</option>
										<option {{ $editData->nationality == 'croatian' ? 'selected' : '' }} value="croatian">Croatian</option>
										<option {{ $editData->nationality == 'cuban' ? 'selected' : '' }} value="cuban">Cuban</option>
										<option {{ $editData->nationality == 'cypriot' ? 'selected' : '' }} value="cypriot">Cypriot</option>
										<option {{ $editData->nationality == 'czech' ? 'selected' : '' }} value="czech">Czech</option>
										<option {{ $editData->nationality == 'danish' ? 'selected' : '' }} value="danish">Danish</option>
										<option {{ $editData->nationality == 'djibouti' ? 'selected' : '' }} value="djibouti">Djibouti</option>
										<option {{ $editData->nationality == 'dominican' ? 'selected' : '' }} value="dominican">Dominican</option>
										<option {{ $editData->nationality == 'dutch' ? 'selected' : '' }} value="dutch">Dutch</option>
										<option {{ $editData->nationality == 'east timorese' ? 'selected' : '' }} value="east timorese">East Timorese</option>
										<option {{ $editData->nationality == 'ecuadorean' ? 'selected' : '' }} value="ecuadorean">Ecuadorean</option>
										<option {{ $editData->nationality == 'egyptian' ? 'selected' : '' }} value="egyptian">Egyptian</option>
										<option {{ $editData->nationality == 'emirian' ? 'selected' : '' }} value="emirian">Emirian</option>
										<option {{ $editData->nationality == 'equatorial guinean' ? 'selected' : '' }} value="equatorial guinean">Equatorial Guinean</option>
										<option {{ $editData->nationality == 'eritrean' ? 'selected' : '' }} value="eritrean">Eritrean</option>
										<option {{ $editData->nationality == 'estonian' ? 'selected' : '' }} value="estonian">Estonian</option>
										<option {{ $editData->nationality == 'ethiopian' ? 'selected' : '' }} value="ethiopian">Ethiopian</option>
										<option {{ $editData->nationality == 'fijian' ? 'selected' : '' }} value="fijian">Fijian</option>
										<option {{ $editData->nationality == 'filipino' ? 'selected' : '' }} value="filipino">Filipino</option>
										<option {{ $editData->nationality == 'finnish' ? 'selected' : '' }} value="finnish">Finnish</option>
										<option {{ $editData->nationality == 'french' ? 'selected' : '' }} value="french">French</option>
										<option {{ $editData->nationality == 'gabonese' ? 'selected' : '' }} value="gabonese">Gabonese</option>
										<option {{ $editData->nationality == 'gambian' ? 'selected' : '' }} value="gambian">Gambian</option>
										<option {{ $editData->nationality == 'georgian' ? 'selected' : '' }} value="georgian">Georgian</option>
										<option {{ $editData->nationality == 'german' ? 'selected' : '' }} value="german">German</option>
										<option {{ $editData->nationality == 'ghanaian' ? 'selected' : '' }} value="ghanaian">Ghanaian</option>
										<option {{ $editData->nationality == 'greek' ? 'selected' : '' }} value="greek">Greek</option>
										<option {{ $editData->nationality == 'grenadian' ? 'selected' : '' }} value="grenadian">Grenadian</option>
										<option {{ $editData->nationality == 'guatemalan' ? 'selected' : '' }} value="guatemalan">Guatemalan</option>
										<option {{ $editData->nationality == 'guinea-bissauan' ? 'selected' : '' }} value="guinea-bissauan">Guinea-Bissauan</option>
										<option {{ $editData->nationality == 'guinean' ? 'selected' : '' }} value="guinean">Guinean</option>
										<option {{ $editData->nationality == 'guyanese' ? 'selected' : '' }} value="guyanese">Guyanese</option>
										<option {{ $editData->nationality == 'haitian' ? 'selected' : '' }} value="haitian">Haitian</option>
										<option {{ $editData->nationality == 'herzegovinian' ? 'selected' : '' }} value="herzegovinian">Herzegovinian</option>
										<option {{ $editData->nationality == 'honduran' ? 'selected' : '' }} value="honduran">Honduran</option>
										<option {{ $editData->nationality == 'hungarian' ? 'selected' : '' }} value="hungarian">Hungarian</option>
										<option {{ $editData->nationality == 'icelander' ? 'selected' : '' }} value="icelander">Icelander</option>
										<option {{ $editData->nationality == 'indian' ? 'selected' : '' }} value="indian">Indian</option>
										<option {{ $editData->nationality == 'indonesian' ? 'selected' : '' }} value="indonesian">Indonesian</option>
										<option {{ $editData->nationality == 'iranian' ? 'selected' : '' }} value="iranian">Iranian</option>
										<option {{ $editData->nationality == 'iraqi' ? 'selected' : '' }} value="iraqi">Iraqi</option>
										<option {{ $editData->nationality == 'irish' ? 'selected' : '' }} value="irish">Irish</option>
										<option {{ $editData->nationality == 'israeli' ? 'selected' : '' }} value="israeli">Israeli</option>
										<option {{ $editData->nationality == 'italian' ? 'selected' : '' }} value="italian">Italian</option>
										<option {{ $editData->nationality == 'ivorian' ? 'selected' : '' }} value="ivorian">Ivorian</option>
										<option {{ $editData->nationality == 'jamaican' ? 'selected' : '' }} value="jamaican">Jamaican</option>
										<option {{ $editData->nationality == 'japanese' ? 'selected' : '' }} value="japanese">Japanese</option>
										<option {{ $editData->nationality == 'jordanian' ? 'selected' : '' }} value="jordanian">Jordanian</option>
										<option {{ $editData->nationality == 'kazakhstani' ? 'selected' : '' }} value="kazakhstani">Kazakhstani</option>
										<option {{ $editData->nationality == 'kenyan' ? 'selected' : '' }} value="kenyan">Kenyan</option>
										<option {{ $editData->nationality == 'kittian and nevisian' ? 'selected' : '' }} value="kittian and nevisian">Kittian and Nevisian</option>
										<option {{ $editData->nationality == 'kuwaiti' ? 'selected' : '' }} value="kuwaiti">Kuwaiti</option>
										<option {{ $editData->nationality == 'kyrgyz' ? 'selected' : '' }} value="kyrgyz">Kyrgyz</option>
										<option {{ $editData->nationality == 'laotian' ? 'selected' : '' }} value="laotian">Laotian</option>
										<option {{ $editData->nationality == 'latvian' ? 'selected' : '' }} value="latvian">Latvian</option>
										<option {{ $editData->nationality == 'lebanese' ? 'selected' : '' }} value="lebanese">Lebanese</option>
										<option {{ $editData->nationality == 'liberian' ? 'selected' : '' }} value="liberian">Liberian</option>
										<option {{ $editData->nationality == 'libyan' ? 'selected' : '' }} value="libyan">Libyan</option>
										<option {{ $editData->nationality == 'liechtensteiner' ? 'selected' : '' }} value="liechtensteiner">Liechtensteiner</option>
										<option {{ $editData->nationality == 'lithuanian' ? 'selected' : '' }} value="lithuanian">Lithuanian</option>
										<option {{ $editData->nationality == 'luxembourger' ? 'selected' : '' }} value="luxembourger">Luxembourger</option>
										<option {{ $editData->nationality == 'macedonian' ? 'selected' : '' }} value="macedonian">Macedonian</option>
										<option {{ $editData->nationality == 'malagasy' ? 'selected' : '' }} value="malagasy">Malagasy</option>
										<option {{ $editData->nationality == 'malawian' ? 'selected' : '' }} value="malawian">Malawian</option>
										<option {{ $editData->nationality == 'malaysian' ? 'selected' : '' }} value="malaysian">Malaysian</option>
										<option {{ $editData->nationality == 'maldivan' ? 'selected' : '' }} value="maldivan">Maldivan</option>
										<option {{ $editData->nationality == 'malian' ? 'selected' : '' }} value="malian">Malian</option>
										<option {{ $editData->nationality == 'maltese' ? 'selected' : '' }} value="maltese">Maltese</option>
										<option {{ $editData->nationality == 'marshallese' ? 'selected' : '' }} value="marshallese">Marshallese</option>
										<option {{ $editData->nationality == 'mauritanian' ? 'selected' : '' }} value="mauritanian">Mauritanian</option>
										<option {{ $editData->nationality == 'mauritian' ? 'selected' : '' }} value="mauritian">Mauritian</option>
										<option {{ $editData->nationality == 'mexican' ? 'selected' : '' }} value="mexican">Mexican</option>
										<option {{ $editData->nationality == 'micronesian' ? 'selected' : '' }} value="micronesian">Micronesian</option>
										<option {{ $editData->nationality == 'moldovan' ? 'selected' : '' }} value="moldovan">Moldovan</option>
										<option {{ $editData->nationality == 'monacan' ? 'selected' : '' }} value="monacan">Monacan</option>
										<option {{ $editData->nationality == 'mongolian' ? 'selected' : '' }} value="mongolian">Mongolian</option>
										<option {{ $editData->nationality == 'moroccan' ? 'selected' : '' }} value="moroccan">Moroccan</option>
										<option {{ $editData->nationality == 'mosotho' ? 'selected' : '' }} value="mosotho">Mosotho</option>
										<option {{ $editData->nationality == 'motswana' ? 'selected' : '' }} value="motswana">Motswana</option>
										<option {{ $editData->nationality == 'mozambican' ? 'selected' : '' }} value="mozambican">Mozambican</option>
										<option {{ $editData->nationality == 'namibian' ? 'selected' : '' }} value="namibian">Namibian</option>
										<option {{ $editData->nationality == 'nauruan' ? 'selected' : '' }} value="nauruan">Nauruan</option>
										<option {{ $editData->nationality == 'nepalese' ? 'selected' : '' }} value="nepalese">Nepalese</option>
										<option {{ $editData->nationality == 'new zealander' ? 'selected' : '' }} value="new zealander">New Zealander</option>
										<option {{ $editData->nationality == 'ni-vanuatu' ? 'selected' : '' }} value="ni-vanuatu">Ni-Vanuatu</option>
										<option {{ $editData->nationality == 'nicaraguan' ? 'selected' : '' }} value="nicaraguan">Nicaraguan</option>
										<option {{ $editData->nationality == 'nigerien' ? 'selected' : '' }} value="nigerien">Nigerien</option>
										<option {{ $editData->nationality == 'north korean' ? 'selected' : '' }} value="north korean">North Korean</option>
										<option {{ $editData->nationality == 'northern irish' ? 'selected' : '' }} value="northern irish">Northern Irish</option>
										<option {{ $editData->nationality == 'norwegian' ? 'selected' : '' }} value="norwegian">Norwegian</option>
										<option {{ $editData->nationality == 'omani' ? 'selected' : '' }} value="omani">Omani</option>
										<option {{ $editData->nationality == 'pakistani' ? 'selected' : '' }} value="pakistani">Pakistani</option>
										<option {{ $editData->nationality == 'palauan' ? 'selected' : '' }} value="palauan">Palauan</option>
										<option {{ $editData->nationality == 'panamanian' ? 'selected' : '' }} value="panamanian">Panamanian</option>
										<option {{ $editData->nationality == 'papua new guinean' ? 'selected' : '' }} value="papua new guinean">Papua New Guinean</option>
										<option {{ $editData->nationality == 'paraguayan' ? 'selected' : '' }} value="paraguayan">Paraguayan</option>
										<option {{ $editData->nationality == 'peruvian' ? 'selected' : '' }} value="peruvian">Peruvian</option>
										<option {{ $editData->nationality == 'polish' ? 'selected' : '' }} value="polish">Polish</option>
										<option {{ $editData->nationality == 'portuguese' ? 'selected' : '' }} value="portuguese">Portuguese</option>
										<option {{ $editData->nationality == 'qatari' ? 'selected' : '' }} value="qatari">Qatari</option>
										<option {{ $editData->nationality == 'romanian' ? 'selected' : '' }} value="romanian">Romanian</option>
										<option {{ $editData->nationality == 'russian' ? 'selected' : '' }} value="russian">Russian</option>
										<option {{ $editData->nationality == 'rwandan' ? 'selected' : '' }} value="rwandan">Rwandan</option>
										<option {{ $editData->nationality == 'saint lucian' ? 'selected' : '' }} value="saint lucian">Saint Lucian</option>
										<option {{ $editData->nationality == 'salvadoran' ? 'selected' : '' }} value="salvadoran">Salvadoran</option>
										<option {{ $editData->nationality == 'samoan' ? 'selected' : '' }} value="samoan">Samoan</option>
										<option {{ $editData->nationality == 'san marinese' ? 'selected' : '' }} value="san marinese">San Marinese</option>
										<option {{ $editData->nationality == 'sao tomean' ? 'selected' : '' }} value="sao tomean">Sao Tomean</option>
										<option {{ $editData->nationality == 'saudi' ? 'selected' : '' }} value="saudi">Saudi</option>
										<option {{ $editData->nationality == 'scottish' ? 'selected' : '' }} value="scottish">Scottish</option>
										<option {{ $editData->nationality == 'senegalese' ? 'selected' : '' }} value="senegalese">Senegalese</option>
										<option {{ $editData->nationality == 'serbian' ? 'selected' : '' }} value="serbian">Serbian</option>
										<option {{ $editData->nationality == 'seychellois' ? 'selected' : '' }} value="seychellois">Seychellois</option>
										<option {{ $editData->nationality == 'sierra leonean' ? 'selected' : '' }} value="sierra leonean">Sierra Leonean</option>
										<option {{ $editData->nationality == 'singaporean' ? 'selected' : '' }} value="singaporean">Singaporean</option>
										<option {{ $editData->nationality == 'slovakian' ? 'selected' : '' }} value="slovakian">Slovakian</option>
										<option {{ $editData->nationality == 'slovenian' ? 'selected' : '' }} value="slovenian">Slovenian</option>
										<option {{ $editData->nationality == 'solomon islander' ? 'selected' : '' }} value="solomon islander">Solomon Islander</option>
										<option {{ $editData->nationality == 'somali' ? 'selected' : '' }} value="somali">Somali</option>
										<option {{ $editData->nationality == 'south african' ? 'selected' : '' }} value="south african">South African</option>
										<option {{ $editData->nationality == 'south korean' ? 'selected' : '' }} value="south korean">South Korean</option>
										<option {{ $editData->nationality == 'spanish' ? 'selected' : '' }} value="spanish">Spanish</option>
										<option {{ $editData->nationality == 'sri lankan' ? 'selected' : '' }} value="sri lankan">Sri Lankan</option>
										<option {{ $editData->nationality == 'sudanese' ? 'selected' : '' }} value="sudanese">Sudanese</option>
										<option {{ $editData->nationality == 'surinamer' ? 'selected' : '' }} value="surinamer">Surinamer</option>
										<option {{ $editData->nationality == 'swazi' ? 'selected' : '' }} value="swazi">Swazi</option>
										<option {{ $editData->nationality == 'swedish' ? 'selected' : '' }} value="swedish">Swedish</option>
										<option {{ $editData->nationality == 'swiss' ? 'selected' : '' }} value="swiss">Swiss</option>
										<option {{ $editData->nationality == 'syrian' ? 'selected' : '' }} value="syrian">Syrian</option>
										<option {{ $editData->nationality == 'taiwanese' ? 'selected' : '' }} value="taiwanese">Taiwanese</option>
										<option {{ $editData->nationality == 'tajik' ? 'selected' : '' }} value="tajik">Tajik</option>
										<option {{ $editData->nationality == 'tanzanian' ? 'selected' : '' }} value="tanzanian">Tanzanian</option>
										<option {{ $editData->nationality == 'thai' ? 'selected' : '' }} value="thai">Thai</option>
										<option {{ $editData->nationality == 'togolese' ? 'selected' : '' }} value="togolese">Togolese</option>
										<option {{ $editData->nationality == 'tongan' ? 'selected' : '' }} value="tongan">Tongan</option>
										<option {{ $editData->nationality == 'trinidadian or tobagonian' ? 'selected' : '' }} value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
										<option {{ $editData->nationality == 'tunisian' ? 'selected' : '' }} value="tunisian">Tunisian</option>
										<option {{ $editData->nationality == 'turkish' ? 'selected' : '' }} value="turkish">Turkish</option>
										<option {{ $editData->nationality == 'tuvaluan' ? 'selected' : '' }} value="tuvaluan">Tuvaluan</option>
										<option {{ $editData->nationality == 'ugandan' ? 'selected' : '' }} value="ugandan">Ugandan</option>
										<option {{ $editData->nationality == 'ukrainian' ? 'selected' : '' }} value="ukrainian">Ukrainian</option>
										<option {{ $editData->nationality == 'uruguayan' ? 'selected' : '' }} value="uruguayan">Uruguayan</option>
										<option {{ $editData->nationality == 'uzbekistani' ? 'selected' : '' }} value="uzbekistani">Uzbekistani</option>
										<option {{ $editData->nationality == 'venezuelan' ? 'selected' : '' }} value="venezuelan">Venezuelan</option>
										<option {{ $editData->nationality == 'vietnamese' ? 'selected' : '' }} value="vietnamese">Vietnamese</option>
										<option {{ $editData->nationality == 'welsh' ? 'selected' : '' }} value="welsh">Welsh</option>
										<option {{ $editData->nationality == 'yemenite' ? 'selected' : '' }} value="yemenite">Yemenite</option>
										<option {{ $editData->nationality == 'zambian' ? 'selected' : '' }} value="zambian">Zambian</option>
										<option {{ $editData->nationality == 'zimbabwean' ? 'selected' : '' }} value="zimbabwean">Zimbabwean</option>
										
									</select>
									
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for=""><span {{ $editData->nationality != 'saudi' ? 'style=display:block' : 'style=display:none' }} id="notqiamnumber">@lang('student.national_id_number')</span>	<span {{ $editData->nationality == 'saudi' ? 'style=display:block' : 'style=display:none' }} id="qiamnumber">@lang('student.iqam_number')</span>										
									{{ in_array('national_id_number', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('national_id_number') ? ' is-invalid' : '' }}"
									type="text" name="national_id_number" value="{{ $editData->national_id_number }}">
									
									
									@if ($errors->has('national_id_number'))
									<span class="text-danger">
										{{ $errors->first('national_id_number') }}
									</span>
									@endif
								</div>
							</div>
							
							@if (in_array('date_of_birth', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input mb-15">
									<label class="primary_input_label" for="">@lang('common.date_of_birth')
									{{ in_array('date_of_birth', $is_required) ? '*' : '' }}</label>
									<div class="primary_datepicker_input">
										<div class="no-gutters input-right-icon">
											<div class="col">
												<div class="">
													<input 
													class="primary_input_field primary_input_field date form-control"
													id="date_of_birth" type="text" name="date_of_birth"
													value="{{ date('m/d/Y', strtotime($editData->date_of_birth)) }}"
													autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#date_of_birth" type="button">
												<i class="ti-calendar" id="start-date-icon"></i>
											</button>
										</div>
									</div>
									<span class="text-danger">{{$errors->first('date_of_birth')}}</span>
								</div>
							</div>
							@endif 
							@if (in_array('date_of_joining', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input mb-15">
									<label class="primary_input_label" for="">@lang('hr.date_of_joining')
									{{ in_array('date_of_joining', $is_required) ? '*' : '' }}</label>
									<div class="primary_datepicker_input">
										<div class="no-gutters input-right-icon">
											<div class="col">
												<div class="">
													<input 
													class="primary_input_field primary_input_field date form-control"
													id="date_of_joining" type="text" name="date_of_joining"
													value="{{ date('m/d/Y', strtotime($editData->date_of_joining)) }} "
													autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#date_of_joining" type="button">
												<i class="ti-calendar" id="start-date-icon"></i>
											</button>
										</div>
									</div>
									<span class="text-danger">{{$errors->first('date_of_joining')}}</span>
								</div>
							</div>
							@endif 
							
							@if (in_array('mobile', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.mobile') {{ in_array('mobile', $is_required) ? '*' : '' }}</label>
									<input oninput="phoneCheck(this)"
									class="primary_input_field form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
									type="text" name="mobile" value="@if (isset($editData)){{ $editData->mobile }}@endif">
									
									
									@if ($errors->has('mobile'))
									<span class="text-danger" >
										{{ $errors->first('mobile') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('marital_status', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.marital_status')
									{{ in_array('marital_status', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="marital_status">
										<option
										data-display="@lang('hr.marital_status') {{ in_array('marital_status', $is_required) ? '*' : '' }}"
										value="">@lang('hr.marital_status')
										{{ in_array('marital_status', $is_required) ? '*' : '' }}</option>
										<option value="married" {{ $editData->marital_status == 'married' ? 'selected' : '' }}>
										@lang('hr.married')</option>
										<option value="unmarried"
										{{ $editData->marital_status == 'unmarried' ? 'selected' : '' }}>@lang('hr.unmarried')
										</option>
										
									</select>
									
								</div>
							</div>
							@endif
							
							@if (in_array('email', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.email') {{ in_array('email', $is_required) ? '*' : '' }}</label>
									<input oninput="emailCheck(this)"
									class="primary_input_field form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
									type="email" name="email" value="@if (isset($editData)){{ $editData->email }}@endif">
									
									
									@if ($errors->has('email'))
									<span class="text-danger" >
										{{ $errors->first('email') }}
									</span>
									@endif
								</div>
							</div>
							@endif 
							
							@if (in_array('fathers_name', $has_permission))  
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('student.father_name')
									{{ in_array('fathers_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}"
									type="text" name="fathers_name" value="@if (isset($editData)){{ $editData->fathers_name }}@endif">
									
									
									@if ($errors->has('fathers_name'))
									<span class="text-danger" >
										{{ $errors->first('fathers_name') }}
									</span>
									@endif
								</div>
							</div>
							@endif 
							@if (in_array('mothers_name', $has_permission))  
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('student.mother_name')
									{{ in_array('mothers_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}"
									type="text" name="mothers_name" value="@if (isset($editData)){{ $editData->mothers_name }}@endif">
									
									
									@if ($errors->has('mothers_name'))
									<span class="text-danger" >
										{{ $errors->first('mothers_name') }}
									</span>
									@endif
								</div>
							</div>
							@endif 
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.emergency_mobile_name')
									{{ in_array('emergency_mobile_name', $is_required) ? '*' : '' }}</label>
									<input  class="primary_input_field form-control{{ $errors->has('emergency_mobile_name') ? ' is-invalid' : '' }}"
									type="text" name="emergency_mobile_name"
									value="@if (isset($editData)){{ $editData->emergency_mobile_name }} @endif">
									
									
									@if ($errors->has('emergency_mobile_name'))
									<span class="text-danger">
										{{ $errors->first('emergency_mobile_name') }}
									</span>
									@endif
								</div>
							</div>
							@if (in_array('emergency_mobile', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.emergency_mobile')
									{{ in_array('emergency_mobile', $is_required) ? '*' : '' }}</label>
									<input oninput="phoneCheck(this)"
									class="primary_input_field form-control{{ $errors->has('emergency_mobile') ? ' is-invalid' : '' }}"
									type="text" name="emergency_mobile" value="@if (isset($editData)){{ $editData->emergency_mobile }} @endif">
									
									
									@if ($errors->has('emergency_mobile'))
									<span class="text-danger" >
										{{ $errors->first('emergency_mobile') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
						</div>
						<div class="row mb-30">
							
							
							
							
						</div>
						<div class="row mb-30">
							
							
							@if (in_array('driving_license', $has_permission)) 
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.driving_license')
										@if ($editData->role_id == 9)
										<span id="driverRole">*</span>
										@else 
										<span id="driverRole" style="display:none">*</span>
										@endif
									{{ in_array('driving_license', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('driving_license') ? ' is-invalid' : '' }}"
									type="text" name="driving_license" value="{{ $editData->driving_license }}">
									
									
									@if ($errors->has('driving_license'))
									<span class="text-danger" >
										{{ $errors->first('driving_license') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
							@if (in_array('staff_photo', $has_permission))                                        
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label"
									for="">{{ trans('hr.staff_photo') }}</label>
									<div class="primary_file_uploader">
										<input
										class="primary_input_field"
										id="placeholderStaffsName" type="text"
										placeholder="{{ $editData->staff_photo != '' ? getFilePath3($editData->staff_photo) : (in_array('staff_photo', $is_required) ? trans('hr.staff_photo') . '*' : trans('hr.staff_photo')) }}"
										readonly>
										<button class="" type="button" id="pic">
											<label class="primary-btn small fix-gr-bg"
											for="staff_photo">@lang('common.browse')</label>
											<input type="file" class="d-none form-control" name="staff_photo"
											id="staff_photo">
										</button>
									</div>
									
									@if ($errors->has('upload_event_image'))
									<span class="text-danger d-block">
										{{ $errors->first('upload_event_image') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
							
						</div>
						
						
						<div class="row mt-40 mt-20">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.document_info')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-30">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						<div class="row mb-20">
							@if (in_array('resume', $has_permission))                            
							<div class="col-lg-4">
								<div class="primary_input">
									<label class="primary_input_label"
									for="">{{ trans('hr.resume') }}</label>
									<div class="primary_file_uploader">
										<input
										class="primary_input_field form-control {{ $errors->has('resume') ? ' is-invalid' : '' }}"
										type="text"
										placeholder="{{ isset($editData->resume) && $editData->resume != '' ? getFilePath3($editData->resume) : (in_array('resume', $is_required) ? trans('hr.resume') . '*' : trans('hr.resume')) }}"
										readonly id="placeholderResume">
										<button class="" type="button" id="pic">
											<label class="primary-btn small fix-gr-bg"
											for="resume">@lang('common.browse')</label>
											<input type="file" class="d-none form-control" name="resume" id="resume">
										</button>
									</div>
									
									@if ($errors->has('upload_event_image'))
									<span class="text-danger d-block">
										{{ $errors->first('upload_event_image') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('joining_letter', $has_permission))
							
							<div class="col-lg-4">
								<div class="primary_input">
									<label class="primary_input_label"
									for="">{{ trans('hr.joining_letter') }}</label>
									<div class="primary_file_uploader">
										<input
										class="primary_input_field form-control {{ $errors->has('joining_letter') ? ' is-invalid' : '' }}"
										type="text"
										placeholder="{{ isset($editData->joining_letter) && $editData->joining_letter != '' ? getFilePath3($editData->joining_letter) : (in_array('joining_letter', $is_required) ? trans('hr.joining_letter') . '*' : trans('hr.joining_letter')) }}"
										readonly id="placeholderJoiningLetter">
										<button class="" type="button" id="pic">
											<label class="primary-btn small fix-gr-bg"
											for="joining_letter">@lang('common.browse')</label>
											<input type="file" class="d-none form-control" name="joining_letter"
											id="joining_letter">
										</button>
									</div>
									
									@if ($errors->has('joining_letter'))
									<span class="text-danger d-block">
										{{ $errors->first('joining_letter') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('other_document', $has_permission))
							
							<div class="col-lg-4">
								<div class="primary_input">
									<label class="primary_input_label"
									for="">{{ trans('hr.other_documents') }}</label>
									<div class="primary_file_uploader">
										<input
										class="primary_input_field form-control {{ $errors->has('other_document') ? ' is-invalid' : '' }}"
										type="text"
										placeholder="{{ isset($editData->other_document) && $editData->other_document != '' ? getFilePath3($editData->joining_letter) : (in_array('other_documents', $is_required) ? trans('hr.other_documents') . '*' : trans('hr.other_documents')) }}"
										readonly id="placeholderOthersDocument">
										<button class="" type="button" id="pic">
											<label class="primary-btn small fix-gr-bg"
											for="other_document">@lang('common.browse')</label>
											<input type="file" class="d-none form-control" name="other_document"
											id="other_document">
										</button>
									</div>
									
									@if ($errors->has('other_document'))
									<span class="text-danger d-block">
										{{ $errors->first('other_document') }}
									</span>
									@endif
								</div>
							</div>
							@endif
						</div>
						
						
						<div class="row">
							<div class="col-lg-4">
								<label class="primary_input_label" for="">@lang('common.specilized_certificate')
								{{ in_array('specilized_certificate', $is_required) ? '*' : '' }}</label>
								<div class="primary_input">
									<div class="primary_file_uploader">
										<input class="primary_input_field" type="text" id="placeholderSpecilized"
										placeholder="{{ isset($editData->specilized_certificate) && $editData->specilized_certificate != '' ? getFilePath3($editData->specilized_certificate) : (in_array('specilized_certificate', $is_required) ? trans('common.specilized_certificate') . '*' : trans('common.specilized_certificate')) }}"
										readonly>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="specilized_certificate">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="specilized_certificate"
											id="specilized_certificate">
										</button>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<label class="primary_input_label" for="">@lang('common.certificate')
								{{ in_array('certificate', $is_required) ? '*' : '' }}</label>
								<div class="primary_input">
									<div class="primary_file_uploader">
										<input class="primary_input_field" type="text" id="placeholderCertificate"
										placeholder="{{ isset($editData->certificate) && $editData->certificate != '' ? getFilePath3($editData->certificate) : (in_array('certificate', $is_required) ? trans('common.certificate') . '*' : trans('common.certificate')) }}"
										readonly>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="certificate">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="certificate"
											id="certificate">
										</button>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<label class="primary_input_label" for="">@lang('hr.national_address')
								{{ in_array('national_address', $is_required) ? '*' : '' }}</label>
								<div class="primary_input">
									<div class="primary_file_uploader">
										<input class="primary_input_field" type="text" id="placeholderOthersDocument"
										placeholder="{{ isset($editData->national_address) && $editData->national_address != '' ? getFilePath3($editData->national_address) : (in_array('national_address', $is_required) ? trans('hr.national_address') . '*' : trans('hr.national_address')) }}"
										readonly>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="national_address">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="national_address"
											id="national_address">
										</button>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<label class="primary_input_label" for="">@lang('hr.certificate_experience')
								{{ in_array('certificate_experience', $is_required) ? '*' : '' }}</label>
								<div class="primary_input">
									<div class="primary_file_uploader">
										<input class="primary_input_field" type="text" id="placeholderOthersDocument"
										placeholder="{{ isset($editData->certificate_experience) && $editData->certificate_experience != '' ? getFilePath3($editData->certificate_experience) : (in_array('certificate_experience', $is_required) ? trans('hr.certificate_experience') . '*' : trans('hr.certificate_experience')) }}"
										readonly>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="certificate_experience">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="certificate_experience"
											id="certificate_experience">
										</button>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<label class="primary_input_label" for="">@lang('hr.national_identity')
								{{ in_array('national_identity', $is_required) ? '*' : '' }}</label>
								<div class="primary_input">
									<div class="primary_file_uploader">
										<input class="primary_input_field" type="text" id="placeholderOthersDocument"
										placeholder="{{ isset($editData->national_identity) && $editData->national_identity != '' ? getFilePath3($editData->national_identity) : (in_array('national_identity', $is_required) ? trans('hr.national_identity') . '*' : trans('hr.national_identity')) }}"
										readonly>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="national_identity">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="national_identity"
											id="national_identity">
										</button>
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="row mb-30">
							@if (in_array('current_address', $has_permission))
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.current_address')
									{{ in_array('current_address', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="current_address"
									id="current_address">@if (isset($editData)){{ $editData->current_address }}@endif</textarea>
									
									<span class="focus-border textarea "></span>
									@if ($errors->has('current_address'))
									<span class="text-danger d-block" >
										{{ $errors->first('current_address') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
							@if (in_array('permanent_address', $has_permission)) 
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.permanent_address')
									{{ in_array('permanent_address', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="permanent_address"
									id="permanent_address">@if (isset($editData)){{ $editData->permanent_address }}@endif</textarea>
									
									
									@if ($errors->has('permanent_address'))
									<span class="danger text-danger">
										{{ $errors->first('permanent_address') }}
									</span>
									@endif
								</div>
							</div>
							@endif
						</div>
						<div class="row mb-30">
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.qualifications')
									{{ in_array('qualifications', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="qualification"
									id="qualification">@if (isset($editData)){{ $editData->qualification }}@endif</textarea>
									
									
									@if ($errors->has('qualification'))
									<span class="danger text-danger">
										{{ $errors->first('qualification') }}
									</span>
									@endif
								</div>
							</div>
							@if (in_array('experience', $has_permission)) 
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.experience') {{ in_array('experience', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="experience"
									id="experience">@if (isset($editData)){{ $editData->experience }}@endif
									</textarea>
									
									
									@if ($errors->has('experience'))
									<span class="danger text-danger">
										{{ $errors->first('experience') }}
									</span>
									@endif
								</div>
							</div>
							@endif
						</div>
						
						@if(moduleStatusCheck('Lms'))
						<div class="row mb-30">
							
							@if (in_array('staff_bio', $has_permission)) 
							<div class="col-lg-12">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('staff.staff_bio')
									{{ in_array('staff_bio', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="6" name="staff_bio"
									id="staff_bio">@if (isset($editData)){{ $editData->staff_bio }}@endif
									</textarea>
									
									
									@if ($errors->has('staff_bio'))
									<span class="danger text-danger">
										{{ $errors->first('staff_bio') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
						</div>
						@endif
						
						
						<div class="row mt-40">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.payroll_details')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-20">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						<div class="row mb-30 mt-20">
							@if (in_array('epf_no', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.epf_no') {{ in_array('epf_no', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('epf_no') ? ' is-invalid' : '' }}"
									type="text" name="epf_no" value="{{ $editData->epf_no }}">
									
									
									@if ($errors->has('epf_no'))
									<span class="text-danger" >
										{{ $errors->first('epf_no') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							
							
							@if (in_array('location', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.location') {{ in_array('location', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
									type="text" name="location" value="{{ $editData->location }}">
									
									
									@if ($errors->has('location'))
									<span class="text-danger" >
										{{ $errors->first('location') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							@if (in_array('contract_type', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.contract_type')
									{{ in_array('contract_type', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="contract_type">
										<option
										data-display="@lang('common.select') {{ in_array('contract_type', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('contract_type', $is_required) ? '*' : '' }}</option>
										<option value="permanent" @if (isset($editData))
										@if ($editData->contract_type == 'permanent')
											selected
											@endif
											@endif
											>@lang('hr.permanent')
										</option>
										<option value="contract" @if (isset($editData))
										@if ($editData->contract_type == 'contract')
											selected
											@endif
											@endif
											> @lang('hr.contract')
										</option>
									</select>
									
									
								</div>
							</div>
							@endif
							<div class="col-lg-3">
								<div class="primary_input mb-15">
									<label class="primary_input_label" for="">@lang('common.contact_start_date')
									{{ in_array('contact_start_date', $is_required) ? '*' : '' }}</label>
									<div class="primary_datepicker_input">
										<div class="no-gutters input-right-icon">
											<div class="col">
												<div class="">
													<input
													class="primary_input_field primary_input_field date form-control"
													id="contact_start_date" type="text" name="contact_start_date"
													value="{{ date('m/d/Y', strtotime($editData->contact_start_date)) }}" autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#contact_start_date" type="button">
												<label class="m-0 p-0" for="contact_start_date">
													<i class="ti-calendar" id="start-date-icon"></i>
												</label>
											</button>
										</div>
									</div>
									<span class="text-danger">{{ $errors->first('contact_start_date') }}</span>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input mb-15">
									<label class="primary_input_label" for="">@lang('common.contact_end_date')
									{{ in_array('contact_end_date', $is_required) ? '*' : '' }}</label>
									<div class="primary_datepicker_input">
										<div class="no-gutters input-right-icon">
											<div class="col">
												<div class="">
													<input
													class="primary_input_field primary_input_field date form-control"
													id="contact_end_date" type="text" name="contact_end_date"
													value="{{ date('m/d/Y', strtotime($editData->contact_end_date)) }}" autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#contact_end_date" type="button">
												<label class="m-0 p-0" for="contact_end_date">
													<i class="ti-calendar" id="start-date-icon"></i>
												</label>
											</button>
										</div>
									</div>
									<span class="text-danger">{{ $errors->first('contact_end_date') }}</span>
								</div>
							</div>
							@if (in_array('basic_salary', $has_permission)) 
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.basic_salary')
									{{ in_array('basic_salary', $is_required) ? '*' : '' }}</label>
									<input oninput="numberCheckWithDot(this)"
									class="primary_input_field form-control{{ $errors->has('basic_salary') ? ' is-invalid' : '' }}"
									type="text" name="basic_salary" value="{{ $editData->basic_salary }}">
									
									
									@if ($errors->has('basic_salary'))
									<span class="text-danger" >
										{{ $errors->first('basic_salary') }}
									</span>
									@endif
								</div>
							</div>
							@endif
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.transportation_allowance')
									{{ in_array('transportation_allowance', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('transportation_allowance') ? ' is-invalid' : '' }}"
									type="text" value="{{ $editData->transportation_allowance }}" name="transportation_allowance">
									
									
									@if ($errors->has('transportation_allowance'))
									<span class="text-danger">
										{{ $errors->first('transportation_allowance') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.housing_allowance')
									{{ in_array('housing_allowance', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('housing_allowance') ? ' is-invalid' : '' }}"
									type="text" value="{{ $editData->housing_allowance  }}" name="housing_allowance">
									
									
									@if ($errors->has('housing_allowance'))
									<span class="text-danger">
										{{ $errors->first('housing_allowance') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.other_allowance')
									{{ in_array('other_allowance', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('other_allowance') ? ' is-invalid' : '' }}"
									type="text" value="{{ $editData->other_allowance  }}" name="other_allowance">
									
									
									@if ($errors->has('other_allowance'))
									<span class="text-danger">
										{{ $errors->first('other_allowance') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.medical_insurance_number')
									{{ in_array('medical_insurance_number', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('medical_insurance_number') ? ' is-invalid' : '' }}"
									type="text" value="{{ $editData->medical_insurance_number  }}" name="medical_insurance_number">
									
									
									@if ($errors->has('medical_insurance_number'))
									<span class="text-danger">
										{{ $errors->first('medical_insurance_number') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.social_insurance_number')
									{{ in_array('social_insurance_number', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('social_insurance_number') ? ' is-invalid' : '' }}"
									type="text" value="{{ $editData->social_insurance_number }}" name="social_insurance_number">
									
									
									@if ($errors->has('social_insurance_number'))
									<span class="text-danger">
										{{ $errors->first('social_insurance_number') }}
									</span>
									@endif
								</div>
							</div>
							
						</div>
						<div class="row mt-40 mt-20">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.location')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-30">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						<div class="row mb-20">
							@if (in_array('bank_account_name', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.bank_account_name')
									{{ in_array('bank_account_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}"
									type="text" name="bank_account_name" value="{{ $editData->bank_account_name }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('bank_account_no', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('accounts.account_no')
									{{ in_array('bank_account_no', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}"
									type="text" name="bank_account_no" value="{{ $editData->bank_account_no }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('bank_name', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('accounts.bank_name')
									{{ in_array('bank_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
									type="text" name="bank_name" value="{{ $editData->bank_name }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('bank_brach', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.branch_name')
									{{ in_array('bank_brach', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('bank_brach') ? ' is-invalid' : '' }}"
									type="text" name="bank_brach" value="{{ $editData->bank_brach }}">
									
									
								</div>
							</div>
							@endif
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('accounts.international_bank_account_no')
									{{ in_array('international_bank_account_no', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('international_bank_account_no') ? ' is-invalid' : '' }}"
									type="text" name="international_bank_account_no" value="{{ $editData->international_bank_account_no }}">
									
								</div>
							</div>
							
						</div>
						
						<div class="row mt-40 mt-20">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.social_links_details')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-30">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						<div class="row mb-20">
							@if (in_array('facebook', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.facebook_url')
									{{ in_array('facebook', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}"
									type="text" name="facebook_url" value="{{ $editData->facebook_url }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('twitter', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.twitter_url') {{ in_array('twitter', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('twiteer_url') ? ' is-invalid' : '' }}"
									type="text" name="twiteer_url" value="{{ $editData->twiteer_url }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('linkedin', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.linkedin_url')
									{{ in_array('linkedin', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}"
									type="text" name="linkedin_url" value="{{ $editData->linkedin_url }}">
									
									
								</div>
							</div>
							@endif
							@if (in_array('instagram', $has_permission))
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.instragram_url')
									{{ in_array('instagram', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('instragram_url') ? ' is-invalid' : '' }}"
									type="text" name="instragram_url" value="{{ $editData->instragram_url }}">
									
									
								</div>
							</div>
							@endif
							
							
						</div>
						
						
						
						{{-- Custom Field Start --}}
						@if (in_array('custom_fields', $has_permission) && isMenuAllowToShow('custom_field') && count($custom_fields) > 0)
						<div class="row mt-40">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.custom_field')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-30">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						
						
						@include('backEnd.studentInformation._custom_field')
						@endif
						
						{{-- Custom Field End --}}
						<div class="row mt-40">
							<div class="col-lg-12 text-center">
								@if (Illuminate\Support\Facades\Config::get('app.app_sync'))
								<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo ">
									<button class="primary-btn small fix-gr-bg  demo_view" style="pointer-events: none;"
								type="button"> @lang('hr.update_staff')</button></span>
								@else
								<button class="primary-btn fix-gr-bg submit">
									<span class="ti-check"></span>
									@lang('hr.update_staff')
								</button>
								@endif
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</section>


<div class="modal" id="LogoPic">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">@lang('hr.crop_image_and_upload')</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="resize"></div>
				<button class="btn rotate float-lef" data-deg="90">
				<i class="ti-back-right"></i></button>
				<button class="btn rotate float-right" data-deg="-90">
				<i class="ti-back-left"></i></button>
				<hr>
				<a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="upload_logo">@lang('hr.crop')</a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ asset('public/backEnd/') }}/js/croppie.js"></script>
<script src="{{ asset('public/backEnd/') }}/js/editStaff.js"></script>
<script>
	$(document).ready(function() {
		$(document).on('change', '.cutom-photo', function() {
			let v = $(this).val();
			let v1 = $(this).data("id");
			console.log(v, v1);
			getFileName(v, v1);
		});
		
		function getFileName(value, placeholder) {
			if (value) {
				var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
				var filename = value.substring(startIndex);
				if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
					filename = filename.substring(1);
				}
				$(placeholder).attr('placeholder', '');
				$(placeholder).attr('placeholder', filename);
			}
		}
	})
	
	function nationalityChange(value) {
		if(value == 'saudi') {
			$('#qiamnumber').show();
			$('#notqiamnumber').hide();
			} else {
			$('#qiamnumber').hide();
			$('#notqiamnumber').show();
		}
	}
</script>
@endsection
@push('script')
<script>
	
	@foreach ($errors->all() as $error)
	toastr.error("{{ $error }}");
	@endforeach
	
</script>
@endpush								