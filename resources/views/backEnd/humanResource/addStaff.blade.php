@extends('backEnd.master')
@section('title')
@lang('hr.add_new_staff')
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backEnd/') }}/css/croppie.css">
<style>
	.input-right-icon button {
	top: 55% !important;
	}
</style>
@endsection
@section('mainContent')
<style type="text/css">
	.form-control:disabled {
	background-color: #FFFFFF;
	}
	
	.input-right-icon button {
	top: 55% !important;
	}
</style>

<input type="text" hidden id="urlStaff" value="{{ route('staffPicStore') }}">
<section class="sms-breadcrumb mb-40 white-box">
	<div class="container-fluid">
		<div class="row justify-content-between">
			<h1>@lang('hr.add_new_staff')</h1>
			<div class="bc-pages">
				<a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
				<a href="{{ route('staff_directory') }}">@lang('hr.human_resource')</a>
				<a href="#">@lang('hr.add_new_staff')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area up_admin_visitor">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-8 col-md-6">
				<div class="main-title">
					<h3 class="mb-30">@lang('hr.staff_information') </h3>
				</div>
			</div>
			<div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg">
				<a href="{{ route('import-staff') }}" class="primary-btn small fix-gr-bg">
					@lang('hr.import_staff')
				</a>
			</div>
		</div>
		{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'staffStore', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
						<div class="row mb-20">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						
						<input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
						@if (moduleStatusCheck('MultiBranch') && isset($branches))
						<div class="row mb-30">
							<div class="col-lg-3">
								<div class="primary_input">
									<select
									class="primary_select  form-control{{ $errors->has('branch_id') ? ' is-invalid' : '' }}"
									name="branch_id" id="branch_id">
										<option data-display="@lang('hr.branch') *" value="">@lang('hr.branch')
										*</option>
										@foreach ($branches as $branch)
										<option value="{{ $branch->id }}"
										{{ isset($branch_id) ? ($branch->id == $branch_id ? 'selected' : '') : '' }}>
										{{ $branch->branch_name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('branch_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('branch_id') }}
									</span>
									@endif
								</div>
							</div>
						</div>
						@endif
						<div class="row mb-30">
							<div class="col-lg-3" style="display:none">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.staff_no')
									{{ in_array('staff_no', $is_required) ? '*' : '' }} </label>
									<input
									class="primary_input_field form-control{{ $errors->has('staff_no') ? ' is-invalid' : '' }}"
									type="text" name="staff_no"
									value="{{ $max_staff_no != '' ? $max_staff_no + 1 : 1 }}" readonly>
									
									
									@if ($errors->has('staff_no'))
									<span class="text-danger">
										{{ $errors->first('staff_no') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.first_name')
									{{ in_array('first_name', $is_required) ? '*' : '' }} </label>
									<input
									class="primary_input_field form-control {{ $errors->has('first_name') ? 'is-invalid' : ' ' }}"
									type="text" name="first_name" value="{{ old('first_name') }}">
									
									
									@if ($errors->has('first_name'))
									<span class="text-danger">
										{{ $errors->first('first_name') }}
									</span>
									@endif
								</div>
							</div>

							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.age')
									{{ in_array('age', $is_required) ? '*' : '' }} </label>
									<input
									class="primary_input_field form-control {{ $errors->has('age') ? 'is-invalid' : ' ' }}"
									type="number" name="age" value="{{ old('age') }}">
								
									@if ($errors->has('age'))
									<span class="text-danger">
										{{ $errors->first('age') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.role')
									{{ in_array('role', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
									name="role_id" id="role_id" onchange="roleIdSelectedSubject(this.value);">
										<option
										data-display="@lang('hr.role') {{ in_array('role', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('role', $is_required) ? '*' : '' }}</option>
										@foreach ($roles as $key => $value)
										<option value="{{ $value->id }}"
										{{ old('role_id') == $value->id ? 'selected' : '' }}>
										{{ $value->name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('role_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('role_id') }}
									</span>
									@endif
								</div>
							</div>
							
							
							
							
							<!--<div class="col-lg-3" id="assign_subjects" style="display:none">
								<div class="primary_input">
								<label class="primary_input_label" for="">@lang('academics.assign_subject')*</label>
								<select multiple class="primary_select  form-control{{ $errors->has('subjects') ? ' is-invalid' : '' }}" name="subjects" id="subjects">
								<option data-display="@lang('academics.assign_subject') {{ in_array('subjects', $is_required) ? '*' : '' }}"
								value="">@lang('common.select') {{ in_array('subjects', $is_required) ? '*' : '' }}</option>
								@foreach ($subjects as $key => $value)
								<option value="{{ $value->id }}" {{ old('subjects') == $value->id ? 'selected' : '' }}>{{ $value->subject_name }}</option>
								@endforeach
								</select>
								
								@if ($errors->has('subjects'))
								<span class="text-danger invalid-select" role="alert">
								{{ $errors->first('subjects') }}
								</span>
								@endif
								</div>
							</div>-->
							
							<div class="col-lg-3">
								<div class="primary_input" id="select_department_div">
									<label class="primary_input_label" for="">@lang('hr.department')
									{{ in_array('department', $is_required) ? '*' : '' }} 

									<span class="text-danger"> *</span>
	                                <a href="javascript:void();" onclick="showPop('modalPopAddDepartment','add_new_department','select_department','select');" class="add_new pull-right" data-toggle="tooltip" title="Add Department" data-original-title="Add Department"><span class="ti-plus"></span> Add</a>
									</label>
									<select
									class="primary_select  form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}"
									name="department_id" id="select_department">
										<option
										data-display="@lang('hr.department') {{ in_array('department', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('department', $is_required) ? '*' : '' }}</option>
										@foreach ($departments as $key => $value)
										<option value="{{ $value->id }}"
										{{ old('department_id') == $value->id ? 'selected' : '' }}>
										{{ $value->name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('department_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('department_id') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input" id="select_designation_div">
									<label class="primary_input_label" for="">@lang('hr.designation')
									{{ in_array('designation', $is_required) ? '*' : '' }} 

									<span class="text-danger"> *</span>
	                                        <a href="javascript:void();" onclick="showPop('modalPopAddDesignation','add_new_designation','select_designation','select');" class="add_new pull-right" data-toggle="tooltip" title="Add Designation" data-original-title="Add Designation"><span class="ti-plus"></span> Add</a>
									</label>
	
									<select
									class="primary_select  form-control{{ $errors->has('designation_id') ? ' is-invalid' : '' }}"
									name="designation_id" id="select_designation">
										<option
										data-display="@lang('hr.designations') {{ in_array('designation', $is_required) ? '*' : '' }}"
										value="">@lang('common.select')
										{{ in_array('designation', $is_required) ? '*' : '' }}</option>
										@foreach ($designations as $key => $value)
										<option value="{{ $value->id }}"
										{{ old('designation_id') == $value->id ? 'selected' : '' }}>
										{{ $value->title }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('designation_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('designation_id') }}
									</span>
									@endif
								</div>
							</div>
							
							
						</div>
						
						
						
						<div class="row mb-30">
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.gender')
									{{ in_array('gender', $is_required) ? '*' : '' }} </label>
									<select
									class="primary_select  form-control{{ $errors->has('gender_id') ? ' is-invalid' : '' }}"
									name="gender_id">
										<option data-display="@lang('common.gender') *" value="">@lang('common.gender')
										{{ in_array('gender', $is_required) ? '*' : '' }}</option>
										@foreach ($genders as $gender)
										<option value="{{ $gender->id }}"
										{{ old('gender_id') == $gender->id ? 'selected' : '' }}>
										{{ $gender->base_setup_name }}</option>
										@endforeach
									</select>
									
									@if ($errors->has('gender_id'))
									<span class="text-danger invalid-select" role="alert">
										{{ $errors->first('gender_id') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.nationality')
									{{ in_array('nationality', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="nationality" onchange="nationalityChange(this.value)">
										<option
										data-display="@lang('common.nationality') {{ in_array('nationality', $is_required) ? '*' : '' }}"
										value="">@lang('common.nationality')
										{{ in_array('nationality', $is_required) ? '*' : '' }}</option>
										
										<option {{ old('nationality') == 'afghan' ? 'selected' : '' }} value="afghan">Afghan</option>
										<option {{ old('nationality') == 'albanian' ? 'selected' : '' }} value="albanian">Albanian</option>
										<option {{ old('nationality') == 'algerian' ? 'selected' : '' }} value="algerian">Algerian</option>
										<option {{ old('nationality') == 'american' ? 'selected' : '' }} value="american">American</option>
										<option {{ old('nationality') == 'andorran' ? 'selected' : '' }} value="andorran">Andorran</option>
										<option {{ old('nationality') == 'angolan' ? 'selected' : '' }} value="angolan">Angolan</option>
										<option {{ old('nationality') == 'antiguans' ? 'selected' : '' }} value="antiguans">Antiguans</option>
										<option {{ old('nationality') == 'argentinean' ? 'selected' : '' }} value="argentinean">Argentinean</option>
										<option {{ old('nationality') == 'armenian' ? 'selected' : '' }} value="armenian">Armenian</option>
										<option {{ old('nationality') == 'australian' ? 'selected' : '' }} value="australian">Australian</option>
										<option {{ old('nationality') == 'austrian' ? 'selected' : '' }} value="austrian">Austrian</option>
										<option {{ old('nationality') == 'azerbaijani' ? 'selected' : '' }} value="azerbaijani">Azerbaijani</option>
										<option {{ old('nationality') == 'bahamian' ? 'selected' : '' }} value="bahamian">Bahamian</option>
										<option {{ old('nationality') == 'bahraini' ? 'selected' : '' }} value="bahraini">Bahraini</option>
										<option {{ old('nationality') == 'bangladeshi' ? 'selected' : '' }} value="bangladeshi">Bangladeshi</option>
										<option {{ old('nationality') == 'barbadian' ? 'selected' : '' }} value="barbadian">Barbadian</option>
										<option {{ old('nationality') == 'barbudans' ? 'selected' : '' }} value="barbudans">Barbudans</option>
										<option {{ old('nationality') == 'batswana' ? 'selected' : '' }} value="batswana">Batswana</option>
										<option {{ old('nationality') == 'belarusian' ? 'selected' : '' }} value="belarusian">Belarusian</option>
										<option {{ old('nationality') == 'belgian' ? 'selected' : '' }} value="belgian">Belgian</option>
										<option {{ old('nationality') == 'belizean' ? 'selected' : '' }} value="belizean">Belizean</option>
										<option {{ old('nationality') == 'beninese' ? 'selected' : '' }} value="beninese">Beninese</option>
										<option {{ old('nationality') == 'bhutanese' ? 'selected' : '' }} value="bhutanese">Bhutanese</option>
										<option {{ old('nationality') == 'bolivian' ? 'selected' : '' }} value="bolivian">Bolivian</option>
										<option {{ old('nationality') == 'bosnian' ? 'selected' : '' }} value="bosnian">Bosnian</option>
										<option {{ old('nationality') == 'brazilian' ? 'selected' : '' }} value="brazilian">Brazilian</option>
										<option {{ old('nationality') == 'british' ? 'selected' : '' }} value="british">British</option>
										<option {{ old('nationality') == 'bruneian' ? 'selected' : '' }} value="bruneian">Bruneian</option>
										<option {{ old('nationality') == 'bulgarian' ? 'selected' : '' }} value="bulgarian">Bulgarian</option>
										<option {{ old('nationality') == 'burkinabe' ? 'selected' : '' }} value="burkinabe">Burkinabe</option>
										<option {{ old('nationality') == 'burmese' ? 'selected' : '' }} value="burmese">Burmese</option>
										<option {{ old('nationality') == 'burundian' ? 'selected' : '' }} value="burundian">Burundian</option>
										<option {{ old('nationality') == 'cambodian' ? 'selected' : '' }} value="cambodian">Cambodian</option>
										<option {{ old('nationality') == 'cameroonian' ? 'selected' : '' }} value="cameroonian">Cameroonian</option>
										<option {{ old('nationality') == 'canadian' ? 'selected' : '' }} value="canadian">Canadian</option>
										<option {{ old('nationality') == 'cape verdean' ? 'selected' : '' }} value="cape verdean">Cape Verdean</option>
										<option {{ old('nationality') == 'central african' ? 'selected' : '' }} value="central african">Central African</option>
										<option {{ old('nationality') == 'chadian' ? 'selected' : '' }} value="chadian">Chadian</option>
										<option {{ old('nationality') == 'chilean' ? 'selected' : '' }} value="chilean">Chilean</option>
										<option {{ old('nationality') == 'chinese' ? 'selected' : '' }} value="chinese">Chinese</option>
										<option {{ old('nationality') == 'colombian' ? 'selected' : '' }} value="colombian">Colombian</option>
										<option {{ old('nationality') == 'comoran' ? 'selected' : '' }} value="comoran">Comoran</option>
										<option {{ old('nationality') == 'congolese' ? 'selected' : '' }} value="congolese">Congolese</option>
										<option {{ old('nationality') == 'costa rican' ? 'selected' : '' }} value="costa rican">Costa Rican</option>
										<option {{ old('nationality') == 'croatian' ? 'selected' : '' }} value="croatian">Croatian</option>
										<option {{ old('nationality') == 'cuban' ? 'selected' : '' }} value="cuban">Cuban</option>
										<option {{ old('nationality') == 'cypriot' ? 'selected' : '' }} value="cypriot">Cypriot</option>
										<option {{ old('nationality') == 'czech' ? 'selected' : '' }} value="czech">Czech</option>
										<option {{ old('nationality') == 'danish' ? 'selected' : '' }} value="danish">Danish</option>
										<option {{ old('nationality') == 'djibouti' ? 'selected' : '' }} value="djibouti">Djibouti</option>
										<option {{ old('nationality') == 'dominican' ? 'selected' : '' }} value="dominican">Dominican</option>
										<option {{ old('nationality') == 'dutch' ? 'selected' : '' }} value="dutch">Dutch</option>
										<option {{ old('nationality') == 'east timorese' ? 'selected' : '' }} value="east timorese">East Timorese</option>
										<option {{ old('nationality') == 'ecuadorean' ? 'selected' : '' }} value="ecuadorean">Ecuadorean</option>
										<option {{ old('nationality') == 'egyptian' ? 'selected' : '' }} value="egyptian">Egyptian</option>
										<option {{ old('nationality') == 'emirian' ? 'selected' : '' }} value="emirian">Emirian</option>
										<option {{ old('nationality') == 'equatorial guinean' ? 'selected' : '' }} value="equatorial guinean">Equatorial Guinean</option>
										<option {{ old('nationality') == 'eritrean' ? 'selected' : '' }} value="eritrean">Eritrean</option>
										<option {{ old('nationality') == 'estonian' ? 'selected' : '' }} value="estonian">Estonian</option>
										<option {{ old('nationality') == 'ethiopian' ? 'selected' : '' }} value="ethiopian">Ethiopian</option>
										<option {{ old('nationality') == 'fijian' ? 'selected' : '' }} value="fijian">Fijian</option>
										<option {{ old('nationality') == 'filipino' ? 'selected' : '' }} value="filipino">Filipino</option>
										<option {{ old('nationality') == 'finnish' ? 'selected' : '' }} value="finnish">Finnish</option>
										<option {{ old('nationality') == 'french' ? 'selected' : '' }} value="french">French</option>
										<option {{ old('nationality') == 'gabonese' ? 'selected' : '' }} value="gabonese">Gabonese</option>
										<option {{ old('nationality') == 'gambian' ? 'selected' : '' }} value="gambian">Gambian</option>
										<option {{ old('nationality') == 'georgian' ? 'selected' : '' }} value="georgian">Georgian</option>
										<option {{ old('nationality') == 'german' ? 'selected' : '' }} value="german">German</option>
										<option {{ old('nationality') == 'ghanaian' ? 'selected' : '' }} value="ghanaian">Ghanaian</option>
										<option {{ old('nationality') == 'greek' ? 'selected' : '' }} value="greek">Greek</option>
										<option {{ old('nationality') == 'grenadian' ? 'selected' : '' }} value="grenadian">Grenadian</option>
										<option {{ old('nationality') == 'guatemalan' ? 'selected' : '' }} value="guatemalan">Guatemalan</option>
										<option {{ old('nationality') == 'guinea-bissauan' ? 'selected' : '' }} value="guinea-bissauan">Guinea-Bissauan</option>
										<option {{ old('nationality') == 'guinean' ? 'selected' : '' }} value="guinean">Guinean</option>
										<option {{ old('nationality') == 'guyanese' ? 'selected' : '' }} value="guyanese">Guyanese</option>
										<option {{ old('nationality') == 'haitian' ? 'selected' : '' }} value="haitian">Haitian</option>
										<option {{ old('nationality') == 'herzegovinian' ? 'selected' : '' }} value="herzegovinian">Herzegovinian</option>
										<option {{ old('nationality') == 'honduran' ? 'selected' : '' }} value="honduran">Honduran</option>
										<option {{ old('nationality') == 'hungarian' ? 'selected' : '' }} value="hungarian">Hungarian</option>
										<option {{ old('nationality') == 'icelander' ? 'selected' : '' }} value="icelander">Icelander</option>
										<option {{ old('nationality') == 'indian' ? 'selected' : '' }} value="indian">Indian</option>
										<option {{ old('nationality') == 'indonesian' ? 'selected' : '' }} value="indonesian">Indonesian</option>
										<option {{ old('nationality') == 'iranian' ? 'selected' : '' }} value="iranian">Iranian</option>
										<option {{ old('nationality') == 'iraqi' ? 'selected' : '' }} value="iraqi">Iraqi</option>
										<option {{ old('nationality') == 'irish' ? 'selected' : '' }} value="irish">Irish</option>
										<option {{ old('nationality') == 'israeli' ? 'selected' : '' }} value="israeli">Israeli</option>
										<option {{ old('nationality') == 'italian' ? 'selected' : '' }} value="italian">Italian</option>
										<option {{ old('nationality') == 'ivorian' ? 'selected' : '' }} value="ivorian">Ivorian</option>
										<option {{ old('nationality') == 'jamaican' ? 'selected' : '' }} value="jamaican">Jamaican</option>
										<option {{ old('nationality') == 'japanese' ? 'selected' : '' }} value="japanese">Japanese</option>
										<option {{ old('nationality') == 'jordanian' ? 'selected' : '' }} value="jordanian">Jordanian</option>
										<option {{ old('nationality') == 'kazakhstani' ? 'selected' : '' }} value="kazakhstani">Kazakhstani</option>
										<option {{ old('nationality') == 'kenyan' ? 'selected' : '' }} value="kenyan">Kenyan</option>
										<option {{ old('nationality') == 'kittian and nevisian' ? 'selected' : '' }} value="kittian and nevisian">Kittian and Nevisian</option>
										<option {{ old('nationality') == 'kuwaiti' ? 'selected' : '' }} value="kuwaiti">Kuwaiti</option>
										<option {{ old('nationality') == 'kyrgyz' ? 'selected' : '' }} value="kyrgyz">Kyrgyz</option>
										<option {{ old('nationality') == 'laotian' ? 'selected' : '' }} value="laotian">Laotian</option>
										<option {{ old('nationality') == 'latvian' ? 'selected' : '' }} value="latvian">Latvian</option>
										<option {{ old('nationality') == 'lebanese' ? 'selected' : '' }} value="lebanese">Lebanese</option>
										<option {{ old('nationality') == 'liberian' ? 'selected' : '' }} value="liberian">Liberian</option>
										<option {{ old('nationality') == 'libyan' ? 'selected' : '' }} value="libyan">Libyan</option>
										<option {{ old('nationality') == 'liechtensteiner' ? 'selected' : '' }} value="liechtensteiner">Liechtensteiner</option>
										<option {{ old('nationality') == 'lithuanian' ? 'selected' : '' }} value="lithuanian">Lithuanian</option>
										<option {{ old('nationality') == 'luxembourger' ? 'selected' : '' }} value="luxembourger">Luxembourger</option>
										<option {{ old('nationality') == 'macedonian' ? 'selected' : '' }} value="macedonian">Macedonian</option>
										<option {{ old('nationality') == 'malagasy' ? 'selected' : '' }} value="malagasy">Malagasy</option>
										<option {{ old('nationality') == 'malawian' ? 'selected' : '' }} value="malawian">Malawian</option>
										<option {{ old('nationality') == 'malaysian' ? 'selected' : '' }} value="malaysian">Malaysian</option>
										<option {{ old('nationality') == 'maldivan' ? 'selected' : '' }} value="maldivan">Maldivan</option>
										<option {{ old('nationality') == 'malian' ? 'selected' : '' }} value="malian">Malian</option>
										<option {{ old('nationality') == 'maltese' ? 'selected' : '' }} value="maltese">Maltese</option>
										<option {{ old('nationality') == 'marshallese' ? 'selected' : '' }} value="marshallese">Marshallese</option>
										<option {{ old('nationality') == 'mauritanian' ? 'selected' : '' }} value="mauritanian">Mauritanian</option>
										<option {{ old('nationality') == 'mauritian' ? 'selected' : '' }} value="mauritian">Mauritian</option>
										<option {{ old('nationality') == 'mexican' ? 'selected' : '' }} value="mexican">Mexican</option>
										<option {{ old('nationality') == 'micronesian' ? 'selected' : '' }} value="micronesian">Micronesian</option>
										<option {{ old('nationality') == 'moldovan' ? 'selected' : '' }} value="moldovan">Moldovan</option>
										<option {{ old('nationality') == 'monacan' ? 'selected' : '' }} value="monacan">Monacan</option>
										<option {{ old('nationality') == 'mongolian' ? 'selected' : '' }} value="mongolian">Mongolian</option>
										<option {{ old('nationality') == 'moroccan' ? 'selected' : '' }} value="moroccan">Moroccan</option>
										<option {{ old('nationality') == 'mosotho' ? 'selected' : '' }} value="mosotho">Mosotho</option>
										<option {{ old('nationality') == 'motswana' ? 'selected' : '' }} value="motswana">Motswana</option>
										<option {{ old('nationality') == 'mozambican' ? 'selected' : '' }} value="mozambican">Mozambican</option>
										<option {{ old('nationality') == 'namibian' ? 'selected' : '' }} value="namibian">Namibian</option>
										<option {{ old('nationality') == 'nauruan' ? 'selected' : '' }} value="nauruan">Nauruan</option>
										<option {{ old('nationality') == 'nepalese' ? 'selected' : '' }} value="nepalese">Nepalese</option>
										<option {{ old('nationality') == 'new zealander' ? 'selected' : '' }} value="new zealander">New Zealander</option>
										<option {{ old('nationality') == 'ni-vanuatu' ? 'selected' : '' }} value="ni-vanuatu">Ni-Vanuatu</option>
										<option {{ old('nationality') == 'nicaraguan' ? 'selected' : '' }} value="nicaraguan">Nicaraguan</option>
										<option {{ old('nationality') == 'nigerien' ? 'selected' : '' }} value="nigerien">Nigerien</option>
										<option {{ old('nationality') == 'north korean' ? 'selected' : '' }} value="north korean">North Korean</option>
										<option {{ old('nationality') == 'northern irish' ? 'selected' : '' }} value="northern irish">Northern Irish</option>
										<option {{ old('nationality') == 'norwegian' ? 'selected' : '' }} value="norwegian">Norwegian</option>
										<option {{ old('nationality') == 'omani' ? 'selected' : '' }} value="omani">Omani</option>
										<option {{ old('nationality') == 'pakistani' ? 'selected' : '' }} value="pakistani">Pakistani</option>
										<option {{ old('nationality') == 'palauan' ? 'selected' : '' }} value="palauan">Palauan</option>
										<option {{ old('nationality') == 'panamanian' ? 'selected' : '' }} value="panamanian">Panamanian</option>
										<option {{ old('nationality') == 'papua new guinean' ? 'selected' : '' }} value="papua new guinean">Papua New Guinean</option>
										<option {{ old('nationality') == 'paraguayan' ? 'selected' : '' }} value="paraguayan">Paraguayan</option>
										<option {{ old('nationality') == 'peruvian' ? 'selected' : '' }} value="peruvian">Peruvian</option>
										<option {{ old('nationality') == 'polish' ? 'selected' : '' }} value="polish">Polish</option>
										<option {{ old('nationality') == 'portuguese' ? 'selected' : '' }} value="portuguese">Portuguese</option>
										<option {{ old('nationality') == 'qatari' ? 'selected' : '' }} value="qatari">Qatari</option>
										<option {{ old('nationality') == 'romanian' ? 'selected' : '' }} value="romanian">Romanian</option>
										<option {{ old('nationality') == 'russian' ? 'selected' : '' }} value="russian">Russian</option>
										<option {{ old('nationality') == 'rwandan' ? 'selected' : '' }} value="rwandan">Rwandan</option>
										<option {{ old('nationality') == 'saint lucian' ? 'selected' : '' }} value="saint lucian">Saint Lucian</option>
										<option {{ old('nationality') == 'salvadoran' ? 'selected' : '' }} value="salvadoran">Salvadoran</option>
										<option {{ old('nationality') == 'samoan' ? 'selected' : '' }} value="samoan">Samoan</option>
										<option {{ old('nationality') == 'san marinese' ? 'selected' : '' }} value="san marinese">San Marinese</option>
										<option {{ old('nationality') == 'sao tomean' ? 'selected' : '' }} value="sao tomean">Sao Tomean</option>
										<option {{ old('nationality') == 'saudi' ? 'selected' : '' }} value="saudi" selected="">Saudi</option>
										<option {{ old('nationality') == 'scottish' ? 'selected' : '' }} value="scottish">Scottish</option>
										<option {{ old('nationality') == 'senegalese' ? 'selected' : '' }} value="senegalese">Senegalese</option>
										<option {{ old('nationality') == 'serbian' ? 'selected' : '' }} value="serbian">Serbian</option>
										<option {{ old('nationality') == 'seychellois' ? 'selected' : '' }} value="seychellois">Seychellois</option>
										<option {{ old('nationality') == 'sierra leonean' ? 'selected' : '' }} value="sierra leonean">Sierra Leonean</option>
										<option {{ old('nationality') == 'singaporean' ? 'selected' : '' }} value="singaporean">Singaporean</option>
										<option {{ old('nationality') == 'slovakian' ? 'selected' : '' }} value="slovakian">Slovakian</option>
										<option {{ old('nationality') == 'slovenian' ? 'selected' : '' }} value="slovenian">Slovenian</option>
										<option {{ old('nationality') == 'solomon islander' ? 'selected' : '' }} value="solomon islander">Solomon Islander</option>
										<option {{ old('nationality') == 'somali' ? 'selected' : '' }} value="somali">Somali</option>
										<option {{ old('nationality') == 'south african' ? 'selected' : '' }} value="south african">South African</option>
										<option {{ old('nationality') == 'south korean' ? 'selected' : '' }} value="south korean">South Korean</option>
										<option {{ old('nationality') == 'spanish' ? 'selected' : '' }} value="spanish">Spanish</option>
										<option {{ old('nationality') == 'sri lankan' ? 'selected' : '' }} value="sri lankan">Sri Lankan</option>
										<option {{ old('nationality') == 'sudanese' ? 'selected' : '' }} value="sudanese">Sudanese</option>
										<option {{ old('nationality') == 'surinamer' ? 'selected' : '' }} value="surinamer">Surinamer</option>
										<option {{ old('nationality') == 'swazi' ? 'selected' : '' }} value="swazi">Swazi</option>
										<option {{ old('nationality') == 'swedish' ? 'selected' : '' }} value="swedish">Swedish</option>
										<option {{ old('nationality') == 'swiss' ? 'selected' : '' }} value="swiss">Swiss</option>
										<option {{ old('nationality') == 'syrian' ? 'selected' : '' }} value="syrian">Syrian</option>
										<option {{ old('nationality') == 'taiwanese' ? 'selected' : '' }} value="taiwanese">Taiwanese</option>
										<option {{ old('nationality') == 'tajik' ? 'selected' : '' }} value="tajik">Tajik</option>
										<option {{ old('nationality') == 'tanzanian' ? 'selected' : '' }} value="tanzanian">Tanzanian</option>
										<option {{ old('nationality') == 'thai' ? 'selected' : '' }} value="thai">Thai</option>
										<option {{ old('nationality') == 'togolese' ? 'selected' : '' }} value="togolese">Togolese</option>
										<option {{ old('nationality') == 'tongan' ? 'selected' : '' }} value="tongan">Tongan</option>
										<option {{ old('nationality') == 'trinidadian or tobagonian' ? 'selected' : '' }} value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
										<option {{ old('nationality') == 'tunisian' ? 'selected' : '' }} value="tunisian">Tunisian</option>
										<option {{ old('nationality') == 'turkish' ? 'selected' : '' }} value="turkish">Turkish</option>
										<option {{ old('nationality') == 'tuvaluan' ? 'selected' : '' }} value="tuvaluan">Tuvaluan</option>
										<option {{ old('nationality') == 'ugandan' ? 'selected' : '' }} value="ugandan">Ugandan</option>
										<option {{ old('nationality') == 'ukrainian' ? 'selected' : '' }} value="ukrainian">Ukrainian</option>
										<option {{ old('nationality') == 'uruguayan' ? 'selected' : '' }} value="uruguayan">Uruguayan</option>
										<option {{ old('nationality') == 'uzbekistani' ? 'selected' : '' }} value="uzbekistani">Uzbekistani</option>
										<option {{ old('nationality') == 'venezuelan' ? 'selected' : '' }} value="venezuelan">Venezuelan</option>
										<option {{ old('nationality') == 'vietnamese' ? 'selected' : '' }} value="vietnamese">Vietnamese</option>
										<option {{ old('nationality') == 'welsh' ? 'selected' : '' }} value="welsh">Welsh</option>
										<option {{ old('nationality') == 'yemenite' ? 'selected' : '' }} value="yemenite">Yemenite</option>
										<option {{ old('nationality') == 'zambian' ? 'selected' : '' }} value="zambian">Zambian</option>
										<option {{ old('nationality') == 'zimbabwean' ? 'selected' : '' }} value="zimbabwean">Zimbabwean</option>
										
									</select>
									
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for=""><span {{ old('nationality') != 'saudi' ? 'style=display:block' : 'style=display:none' }} id="notqiamnumber">@lang('student.national_id_number')</span>	<span {{ old('nationality') == 'saudi' ? 'style=display:block' : 'style=display:none' }} id="qiamnumber">@lang('student.iqam_number')</span>										
									{{ in_array('national_id_number', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('national_id_number') ? ' is-invalid' : '' }}"
									type="text" name="national_id_number" value="{{ old('national_id_number') }}">
									
									
									@if ($errors->has('national_id_number'))
									<span class="text-danger">
										{{ $errors->first('national_id_number') }}
									</span>
									@endif
								</div>
							</div>
							
							
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
													value="{{ old('date_of_birth') }}" autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#date_of_birth" type="button">
												<label class="m-0 p-0" for="date_of_birth">
													<i class="ti-calendar" id="start-date-icon"></i>
												</label>
											</button>
										</div>
									</div>
									<span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
								</div>
							</div>
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
													value="{{ date('m/d/Y') }}" autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#date_of_joining" type="button">
												<label class="m-0 p-0" for="date_of_joining">
													<i class="ti-calendar" id="start-date-icon"></i>
												</label>
											</button>
										</div>
									</div>
									<span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
								</div>
							</div>
							
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.mobile')
									{{ in_array('mobile', $is_required) ? '*' : '' }}</label>
									<input oninput="phoneCheck(this)"
									class="primary_input_field form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
									type="text" name="mobile" value="{{ old('mobile') }}">
									
									
									@if ($errors->has('mobile'))
									<span class="text-danger">
										{{ $errors->first('mobile') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.marital_status')
									{{ in_array('marital_status', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="marital_status">
										<option
										data-display="@lang('hr.marital_status') {{ in_array('marital_status', $is_required) ? '*' : '' }}"
										value="">@lang('hr.marital_status')
										{{ in_array('marital_status', $is_required) ? '*' : '' }}</option>
										
										<option {{ old('marital_status') == 'married' ? 'selected' : '' }}
										value="married">@lang('hr.married')</option>
										<option {{ old('marital_status') == 'unmarried' ? 'selected' : '' }}
										value="unmarried">@lang('hr.unmarried')</option>
										
									</select>
									
								</div>
							</div>
							
							
							<div class="col-lg-3" style="display:none;">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.last_name')
									{{ in_array('last_name', $is_required) ? '*' : '' }} </label>
									<input
									class="primary_input_field form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
									type="text" name="last_name" value="{{ old('last_name') }}">
									
									
									@if ($errors->has('last_name'))
									<span class="text-danger">
										{{ $errors->first('last_name') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('student.father_name')
									{{ in_array('fathers_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}"
									type="text" name="fathers_name" value="{{ old('first_name') }}">
									
									
									@if ($errors->has('fathers_name'))
									<span class="text-danger">
										{{ $errors->first('fathers_name') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.mother_name')
									{{ in_array('mothers_name', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}"
									type="text" name="mothers_name" value="{{ old('mothers_name') }}">
									
									
									@if ($errors->has('mothers_name'))
									<span class="text-danger">
										{{ $errors->first('mothers_name') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.email')
									{{ in_array('email', $is_required) ? '*' : '' }} </label>
									<input onkeyup="emailCheck(this)"
									class="primary_input_field form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
									type="email" name="email" value="{{ old('email') }}">
									
									
									@if ($errors->has('email'))
									<span class="text-danger">
										{{ $errors->first('email') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.emergency_mobile_name')
									{{ in_array('emergency_mobile_name', $is_required) ? '*' : '' }}</label>
									<input  class="primary_input_field form-control{{ $errors->has('emergency_mobile_name') ? ' is-invalid' : '' }}"
									type="text" name="emergency_mobile_name"
									value="{{ old('emergency_mobile_name') }}">
									
									
									@if ($errors->has('emergency_mobile_name'))
									<span class="text-danger">
										{{ $errors->first('emergency_mobile_name') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.emergency_mobile')
									{{ in_array('emergency_mobile', $is_required) ? '*' : '' }}</label>
									<input oninput="phoneCheck(this)"
									class="primary_input_field form-control{{ $errors->has('emergency_mobile') ? ' is-invalid' : '' }}"
									type="text" name="emergency_mobile"
									value="{{ old('emergency_mobile') }}">
									
									
									@if ($errors->has('emergency_mobile'))
									<span class="text-danger">
										{{ $errors->first('emergency_mobile') }}
									</span>
									@endif
								</div>
							</div>
						</div>
							
						
						<div class="row mb-20">
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.driving_license')
										@if ($errors->has('role_id') == 9)
										<span id="driverRole">*</span>
										@else 
										<span id="driverRole" style="display:none">*</span>
										@endif
										
									{{ in_array('driving_license', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('driving_license') ? ' is-invalid' : '' }}"
									type="text" name="driving_license" value="{{ old('driving_license') }}">
									
									
									@if ($errors->has('driving_license'))
									<span class="text-danger">
										{{ $errors->first('driving_license') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.staff_photo')
									{{ in_array('staff_photo', $is_required) ? '*' : '' }}</label>
									<div class="primary_file_uploader">
										<input
										class="primary_input_field form-control {{ $errors->has('staff_photo') ? ' is-invalid' : '' }}"
										type="text" id="placeholderStaffsName"
										placeholder="{{ isset($editData->file) && $editData->file != '' ? getFilePath3($editData->file) : (in_array('staff_photo', $is_required) ? trans('hr.staff_photo') . '*' : trans('hr.staff_photo')) }}"
										disabled>
										<code>(JPG,JPEG,PNG are allowed for upload)</code>
										<button class="" type="button">
											<label class="primary-btn small fix-gr-bg"
											for="staff_photo">{{ __('common.browse') }}</label>
											<input type="file" class="d-none" name="staff_photo"
											id="staff_photo">
										</button>
									</div>
								</div>
							</div>
						</div>
						
						
					<div class="row mt-40">
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
						<div class="col-lg-4">
							
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.resume')
								{{ in_array('resume', $is_required) ? '*' : '' }}</label>
								<div class="primary_file_uploader">
									<input class="primary_input_field" type="text" id="placeholderResume"
									placeholder="{{ isset($editData->resume) && $editData->resume != '' ? getFilePath3($editData->resume) : (in_array('resume', $is_required) ? trans('hr.resume') . '*' : trans('hr.resume')) }}"
									readonly>
									<button class="" type="button">
										<label class="primary-btn small fix-gr-bg"
										for="resume">{{ __('common.browse') }}</label>
										<input type="file" class="d-none" name="resume" id="resume">
									</button>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.joining_letter')
								{{ in_array('joining_letter', $is_required) ? '*' : '' }}</label>
								<div class="primary_file_uploader">
									<input class="primary_input_field" type="text" id="placeholderJoiningLetter"
									placeholder="{{ isset($editData->joining_letter) && $editData->joining_letter != '' ? getFilePath3($editData->joining_letter) : (in_array('joining_letter', $is_required) ? trans('hr.joining_letter') . '*' : trans('hr.joining_letter')) }}"
									readonly>
									<button class="" type="button">
										<label class="primary-btn small fix-gr-bg"
										for="joining_letter">{{ __('common.browse') }}</label>
										<input type="file" class="d-none" name="joining_letter"
										id="joining_letter">
									</button>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<label class="primary_input_label" for="">@lang('hr.other_documents')
							{{ in_array('other_documents', $is_required) ? '*' : '' }}</label>
							<div class="primary_input">
								<div class="primary_file_uploader">
									<input class="primary_input_field" type="text" id="placeholderOthersDocument"
									placeholder="{{ isset($editData->other_document) && $editData->other_document != '' ? getFilePath3($editData->other_document) : (in_array('other_documents', $is_required) ? trans('hr.other_documents') . '*' : trans('hr.other_documents')) }}"
									readonly>
									<button class="" type="button">
										<label class="primary-btn small fix-gr-bg"
										for="other_document">{{ __('common.browse') }}</label>
										<input type="file" class="d-none" name="other_document"
										id="other_document">
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label class="primary_input_label" for="">@lang('common.specilized_certificate')
							{{ in_array('specilized_certificate', $is_required) ? '*' : '' }}</label>
							<div class="primary_input">
								<div class="primary_file_uploader">
									<input class="primary_input_field" type="text" id="placeholderOthersDocument"
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
									<input class="primary_input_field" type="text" id="placeholderOthersDocument"
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
						<div class="col-lg-12">
							<hr>
						</div>
					</div>
					
					<div class="row mt-40">
						<div class="col-lg-12">
							<div class="main-title">
								<h4>@lang('hr.bank_info_details')</h4>
							</div>
						</div>
					</div>
					<div class="row mb-30">
						<div class="col-lg-12">
							<hr>
						</div>
					</div>
					<div class="row mb-20">
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.bank_account_name')
								{{ in_array('bank_account_name', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}"
								type="text" name="bank_account_name" value="{{ old('bank_account_name') }}">
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('accounts.account_no')
								{{ in_array('bank_account_no', $is_required) ? '*' : '' }}</label>
								
								<input onkeyup="numberCheck(this)"
								class="primary_input_field form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}"
								type="text" name="bank_account_no" value="{{ old('bank_account_no') }}">
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('accounts.bank_name')
								{{ in_array('bank_name', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
								type="text" name="bank_name" value="{{ old('bank_name') }}">
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('accounts.branch_name')
								{{ in_array('bank_brach', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('bank_brach') ? ' is-invalid' : '' }}"
								type="text" name="bank_brach" value="{{ old('bank_brach') }}">
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('accounts.international_bank_account_no')
								{{ in_array('international_bank_account_no', $is_required) ? '*' : '' }}</label>
								
								<input onkeyup="numberCheck(this)"
								class="primary_input_field form-control{{ $errors->has('international_bank_account_no') ? ' is-invalid' : '' }}"
								type="text" name="international_bank_account_no" value="{{ old('international_bank_account_no') }}">
								
								
							</div>
						</div>
					</div>
					
						
						<div class="row mb-30">
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.current_address')
									{{ in_array('current_address', $is_required) ? '*' : '' }} </label>
									<textarea class="primary_input_field form-control {{ $errors->has('current_address') ? 'is-invalid' : '' }}"
									cols="0" rows="4" name="current_address" id="current_address">{{ old('current_address') }}</textarea>
									
									
									
									@if ($errors->has('current_address'))
									<span class="text-danger">
										{{ $errors->first('current_address') }}
									</span>
									@endif
								</div>
								
							</div>
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.permanent_address')
									{{ in_array('permanent_address', $is_required) ? '*' : '' }} </label>
									<textarea class="primary_input_field form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}"
									cols="0" rows="4" name="permanent_address" id="permanent_address">{{ old('permanent_address') }}</textarea>
									
									
									@if ($errors->has('permanent_address'))
									<span class="text-danger">
										{{ $errors->first('permanent_address') }}
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row md-20">
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.qualifications')
									{{ in_array('qualifications', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="qualification"
									id="qualification">{{ old('qualification') }}</textarea>
									
									
									@if ($errors->has('qualification'))
									<span class="danger text-danger">
										{{ $errors->first('qualification') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.experience')
									{{ in_array('experience', $is_required) ? '*' : '' }}</label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="experience" id="experience"
									value="{{ old('experience') }}"></textarea>
									
									
									@if ($errors->has('experience'))
									<span class="danger text-danger">
										{{ $errors->first('experience') }}
									</span>
									@endif
								</div>
							</div>
						</div>
						
						<div class="row mt-40">
							<div class="col-lg-12">
								<div class="main-title">
									<h4>@lang('hr.payroll_details')</h4>
								</div>
							</div>
						</div>
						<div class="row mb-30">
							<div class="col-lg-12">
								<hr>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-4">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.contract_type')
									{{ in_array('contract_type', $is_required) ? '*' : '' }} </label>
									<select class="primary_select  form-control" name="contract_type">
										<option
										data-display="@lang('hr.contract_type') {{ in_array('contract_type', $is_required) ? '*' : '' }}"
										value=""> @lang('hr.contract_type')
										{{ in_array('contract_type', $is_required) ? '*' : '' }}</option>
										<option value="permanent">@lang('hr.permanent') </option>
										<option value="contract"> @lang('hr.contract')</option>
									</select>
									
									
								</div>
							</div>
							
							<div class="col-lg-4">
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
													value="{{ old('contact_start_date') }}" autocomplete="off">
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
							
							<div class="col-lg-4">
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
													value="{{ old('contact_end_date') }}" autocomplete="off">
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
							
							
						</div>
						
						<div class="row mb-20">
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.epf_no')
									{{ in_array('epf_no', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('epf_no') ? ' is-invalid' : '' }}"
									type="text" name="epf_no" value="{{ old('epf_no') }}">
									
									
									@if ($errors->has('epf_no'))
									<span class="text-danger">
										{{ $errors->first('epf_no') }}
									</span>
									@endif
								</div>
							</div>
							
							
							
							
							<div class="col-lg-6">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.location')
									{{ in_array('location', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
									type="text" value="{{ old('location') }}" name="location">
									
									
									@if ($errors->has('location'))
									<span class="text-danger">
										{{ $errors->first('location') }}
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('hr.basic_salary')
									{{ in_array('basic_salary', $is_required) ? '*' : '' }}</label>
									<input oninput="numberCheck(this)"
									class="primary_input_field form-control{{ $errors->has('basic_salary') ? ' is-invalid' : '' }}"
									type="text" name="basic_salary" value="{{ old('basic_salary') }}"
									autocomplete="off">
									
									
									@if ($errors->has('basic_salary'))
									<span class="text-danger">
										{{ $errors->first('basic_salary') }}
									</span>
									@endif
								</div>
							</div>
							<div class="col-lg-3">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.transportation_allowance')
									{{ in_array('transportation_allowance', $is_required) ? '*' : '' }}</label>
									<input
									class="primary_input_field form-control{{ $errors->has('transportation_allowance') ? ' is-invalid' : '' }}"
									type="text" value="{{ old('transportation_allowance') }}" name="transportation_allowance">
									
									
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
									type="text" value="{{ old('housing_allowance') }}" name="housing_allowance">
									
									
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
									type="text" value="{{ old('other_allowance') }}" name="other_allowance">
									
									
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
									type="text" value="{{ old('medical_insurance_number') }}" name="medical_insurance_number">
									
									
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
									type="text" value="{{ old('social_insurance_number') }}" name="social_insurance_number">
									
									
									@if ($errors->has('social_insurance_number'))
									<span class="text-danger">
										{{ $errors->first('social_insurance_number') }}
									</span>
									@endif
								</div>
							</div>
							
						</div>
					</div>
					
					
					
					<div class="row mt-40">
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
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.facebook_url')
								{{ in_array('facebook', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}"
								type="text" name="facebook_url" value={{ old('facebook_url') }}>
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.twitter_url')
								{{ in_array('twitter', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('twiteer_url') ? ' is-invalid' : '' }}"
								type="text" name="twiteer_url" value="{{ old('twiteer_url') }}">
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.linkedin_url')
								{{ in_array('linkedin', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}"
								type="text" name="linkedin_url" value="{{ old('linkedin_url') }}">
								
								
								
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="primary_input">
								<label class="primary_input_label" for="">@lang('hr.instragram_url')
								{{ in_array('instragram', $is_required) ? '*' : '' }}</label>
								<input
								class="primary_input_field form-control{{ $errors->has('instragram_url') ? ' is-invalid' : '' }}"
								type="text" name="instragram_url" value="{{ old('instragram_url') }}">
								
								
								
							</div>
						</div>
						
					</div>
					
					@if (isset($custom_fields) && $custom_fields->count())
					{{-- Custom Field Start --}}
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
					{{-- Custom Field End --}}
					@endif
					<div class="row mt-40">
						<div class="col-lg-12 text-center">
							<button class="primary-btn fix-gr-bg submit">
								<span class="ti-check"></span>
								@lang('hr.save_staff')
								
							</button>
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
				
				<a href="javascript:;" class="primary-btn fix-gr-bg pull-right"
				id="upload_logo">@lang('hr.crop')</a>
			</div>
		</div>
	</div>
</div>
@endsection
@include('backEnd.partials.date_picker_css_js')
@section('script')
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
</script>
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
	
	function roleIdSelectedSubject(role_id){
		/*$('#assign_subjects').hide();*/
		$('#driverRole').hide();
		/*if(role_id == 4) {
			$('#assign_subjects').show();
		}*/
		if(role_id == 9) {
			$('#driverRole').show();
		}
	}
	
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
