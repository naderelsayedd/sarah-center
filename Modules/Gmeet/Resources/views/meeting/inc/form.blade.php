<div class="col-lg-3">

<div class="white-box">
<div class="main-title">
        <h3 class="mb-15">
            @if (isset($editdata))
                @lang('common.edit_meeting')
            @else
                @lang('common.add_meeting')
            @endif

        </h3>
    </div>

    @if (isset($editdata))
        {!! Form::open([
            'class' => 'form-horizontal',
            'route' => ['g-meet.virtual-meeting.update', $editdata->id],
            'method' => 'PUT',
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'class' => 'form-horizontal',
            'route' => 'g-meet.virtual-meeting.store',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div >
                <div class="row ">
                    <div class="col-lg-12 ">
                        <div class="primary_input">
                            <label for="checkbox" class="mb-2">@lang('common.member_type') <span class="text-danger"> *</span></label>
                            <select
                                class="primary_select  user_type form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}"
                                name="member_type">
                                <option data-display=" @lang('common.member_type') *" value="">@lang('common.member_type') *</option>
                                @foreach ($roles as $value)
                                    @if (isset($editdata))
                                        <option value="{{ $value->id }}"
                                            {{ $value->id == $user_type ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('member_type'))
                            <span class="text-danger invalid-select" role="alert">
                                {{ $errors->first('member_type') }}
                            </span>
                        @endif
                    </div>
                </div>
             
                <div class="row mt-15">
                    <div class="col-lg-12" id="selectTeacherDiv">
                        <label for="checkbox" class="mb-2">@lang('common.member') <span class="text-danger"> *</span></label>
                        <select multiple id="selectMultiUsers" class="multypol_check_select active position-relative" name="participate_ids[]"
                            >
                            @if (isset($editdata))
                                @foreach ($userList as $value)
                                    <option value="{{ $value->id }}" {{ in_array($value->id, $editdata->participates->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $value->full_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('participate_ids'))
                            <span class="text-danger d-block" >
                                {{ $errors->first('participate_ids') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('common.topic')<span class="text-danger"> *</span></label>
                            <input class="primary_input_field form-control{{ $errors->has('topic') ? ' is-invalid' : '' }}"
                                type="text" name="topic" autocomplete="off"
                                value="{{ isset($editdata) ? old('topic', $editdata->topic) : old('topic') }}">
                            
                            
                            @if ($errors->has('topic'))
                                <span class="text-danger" >
                                    {{ $errors->first('topic') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @if(@gMainSettings()->use_api == 0)
               
                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('gmeet::gmeet.gmeet_url') <span class="text-danger"> *</span></label>
                            <textarea class="primary_input_field form-control" cols="0" rows="4" name="gmeet_url" id="gmeet_url">{{ isset($editdata) ? old('gmeet_url', $editdata->gmeet_url) : old('gmeet_url') }}</textarea>
                            
                            
                            @if ($errors->has('gmeet_url'))
                                <span class="text-danger d-block" >
                                    {{ $errors->first('gmeet_url') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('common.description')</label>
                            <textarea class="primary_input_field form-control" cols="0" rows="4" name="description" id="address">{{ isset($editdata) ? old('description', $editdata->description) : old('description') }}</textarea>
                           
                            
                            @if ($errors->has('description'))
                                <span class="text-danger" >
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('common.date_of_meeting')<span class="text-danger"> *</span></label>
                            <div class="primary_datepicker_input">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input class="primary_input_field  primary_input_field date form-control form-control" id="startDate" type="text" name="date"
                                                readonly="true"
                                                value="{{ isset($editdata) ? old('date', Carbon\Carbon::parse($editdata->date_of_meeting)->format('m/d/Y')) : old('date', Carbon\Carbon::now()->format('m/d/Y')) }}"
                                                required>
                                        </div>
                                    </div>
                                    <button class="btn-date" data-id="#startDate" type="button">
                                        <label class="m-0 p-0" for="startDate">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </label>
                                    </button>
                                </div>
                            </div>
                            @if ($errors->has('date'))
                                <span class="text-danger" >
                                    {{ $errors->first('date') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-15">
                    <div class="col-lg-12">
                        @if ($errors->has('time'))
                            <span class="text-danger" >
                                {{ @$errors->first('time') }}
                            </span>
                        @endif
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('gmeet::gmeet.time_of_meeting')<span class="text-danger"> *</span></label>
                            <div class="primary_datepicker_input">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input class="primary_input_field primary_input_field time form-control{{ @$errors->has('time') ? ' is-invalid' : '' }}"
                                            type="text" name="time" id="dateOfMeeting"
                                            value="{{ isset($editdata) ? old('time', $editdata->time_of_meeting) : old('time') }}">
                                                
                                            @if ($errors->has('time'))
                                            <span class="text-danger d-block" >
                                                {{ $errors->first('time') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <label class="m-0 p-0" for="dateOfMeeting">
                                            <i class="ti-alarm-clock " id="admission-date-icon"></i>
                                        </label>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('gmeet::gmeet.meeting_duration')<span class="text-danger"> *</span></label>
                            <input type="number" {{-- oninput="numberCheck(this)" --}}
                                class="primary_input_field form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                type="text" name="duration" autocomplete="off"
                                value="{{ isset($editdata) ? old('duration', $editdata->meeting_duration) : old('duration') }}">
                            @if ($errors->has('duration'))
                                <span class="text-danger" >
                                    {{ $errors->first('duration') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-15">
                    <div class="col-lg-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('common.meeting_start_before')</label>
                            <input type="number" {{-- oninput="numberCheck(this)" --}}
                                class="primary_input_field form-control{{ $errors->has('time_start_before') ? ' is-invalid' : '' }}"
                                type="text" name="time_start_before" autocomplete="off"
                                value="{{ isset($editdata) ? old('time_start_before', $editdata->time_before_start) : 10 }}">
                            @if ($errors->has('time_start_before'))
                                <span class="text-danger" >
                                    {{ $errors->first('time_start_before') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if(@gMainSettings()->use_api == 1)
                    <div class="row mt-30">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10 w_130" >@lang('gmeet::gmeet.recurring')</p>
                            <div class="d-flex radio-btn-flex mt-15">
                                @if (isset($editdata))
                                    <div class="mr-20 ml-2">
                                        <input type="radio" name="is_recurring" id="recurring_options1" value="1"
                                            class="common-radio recurring-type"
                                            {{ old('is_recurring', $editdata->is_recurring) == 1 ? 'checked' : '' }}>
                                        <label for="recurring_options1">@lang('common.yes')</label>
                                    </div>
                                    <div class="mr-20">
                                        <input type="radio" name="is_recurring" id="recurring_options2" value="0"
                                            class="common-radio recurring-type"
                                            {{ old('is_recurring', $editdata->is_recurring) == 0 ? 'checked' : '' }}>
                                        <label for="recurring_options2">@lang('common.no')</label>
                                    </div>
                                @else
                                    <div class="mr-20 ml-2">
                                        <input type="radio" name="is_recurring" id="recurring_options1" value="1"
                                            class="common-radio recurring-type"
                                            {{ old('is_recurring') == 1 ? 'checked' : '' }}>
                                        <label for="recurring_options1">@lang('common.yes')</label>
                                    </div>
                                    <div class="mr-20">
                                        <input type="radio" name="is_recurring" id="recurring_options2" value="0"
                                            class="common-radio recurring-type"
                                            {{ old('is_recurring') == 0 ? 'checked' : '' }}>
                                        <label for="recurring_options2">@lang('common.no')</label>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="row mt-20 recurrence-section-hide">
                        <div class="col-lg-6">
                            <select
                                class="primary_select form-control {{ @$errors->has('recurring_type') ? ' is-invalid' : '' }}"
                                id="recurring_type" name="recurring_type">
                                <option data-display="@lang('gmeet::gmeet.type') *" value="">@lang('gmeet::gmeet.type') *</option>
                                @if (isset($editdata))
                                    <option value="1"
                                        {{ old('recurring_type', $editdata->recurring_type) == 1 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_daily')</option>
                                    <option value="2"
                                        {{ old('recurring_type', $editdata->recurring_type) == 2 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_weekly')</option>
                                    <option value="3"
                                        {{ old('recurring_type', $editdata->recurring_type) == 3 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_monthly') </option>
                                @else
                                    <option value="1" {{ old('recurring_type') == 1 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_daily')</option>
                                    <option value="2" {{ old('recurring_type') == 2 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_weekly')</option>
                                    <option value="3" {{ old('recurring_type') == 3 ? 'selected' : '' }}>
                                        @lang('gmeet::gmeet.recurring_monthly') </option>
                                @endif
                            </select>
                            @if ($errors->has('recurring_type'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ @$errors->first('recurring_type') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <select
                                class="primary_select form-control {{ @$errors->has('recurring_repeat_day') ? ' is-invalid' : '' }}"
                                id="recurring_repeat_day" name="recurring_repeat_day">
                                <option data-display=" @lang('common.select') *" value="">@lang('gmeet::gmeet.recurring_repect') *</option>
                                @for ($i = 1; $i <= 15; $i++)
                                    @if (isset($editdata))
                                        <option value="{{ $i }}"
                                            {{ old('recurring_repeat_day', $editdata->recurring_repeat_day) == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}"
                                            {{ old('recurring_repeat_day') == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                            @if ($errors->has('recurring_repeat_day'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ @$errors->first('recurring_repeat_day') }}
                                </span>
                            @endif
                        </div>

                        <div class="row mt-30 day_hide" id="day_hide">
                            <div class="col-lg-12 ml-15">
                                <label class="primary_input_label" for="">@lang('gmeet::gmeet.occurs_on') <span class="text-danger"> *</span></label>
                                @foreach ($days as $day)
                                    <div class="row ml-15">
                                        <div class="">
                                            @if (isset($editdata))
                                                <input type="checkbox" id="day{{ @$day->id }}"
                                                    class="common-checkbox weekDays form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                    name="days[]"
                                                    value="{{@$day->gmeet_day }}">
                                                <label for="day{{ @$day->id }}">{{ @$day->name }}</label>
                                            @else
                                                <input type="checkbox" id="day{{ @$day->id }}"
                                                    class="common-checkbox weekDays form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                    name="days[]" value="{{@$day->gmeet_day }}">
                                                <label for="day{{ @$day->id }}"> {{ @$day->name }}</label>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                                @if ($errors->has('days'))
                                    <span class="text-danger d-block"  >
                                        {{ $errors->first('days') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="row mt-30 recurrence-section-hide">
                        <div class="col-lg-12">
                            <label class="primary_input_label" for="">@lang('gmeet::gmeet.recurring_end') <span class="text-danger"> *</span></label>
                            <input class="primary_input_field  primary_input_field date form-control form-control" sty id="recurring_end_date" type="text"
                                name="recurring_end_date" readonly="true"
                                value="{{ isset($editdata) ? old('recurring_end_date', Carbon\Carbon::parse($editdata->recurring_end_date)->format('m/d/Y')) : old('recurring_end_date') }}"
                                required>
                            @if ($errors->has('recurring_end_date'))
                                <span class="text-danger" >
                                    {{ $errors->first('recurring_end_date') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-15">
                        <div class="col-lg-12" id="selectTeacherDiv">
                            <label for="visibility" class="mb-2">@lang('gmeet::gmeet.Visibility') <span class="text-danger"> *</span></label>
                            @php
                                $visibilities = 
                                [
                                    'private'=>'Private',
                                    'public'=>'Public',
                                ];
                            @endphp
                            @foreach ($visibilities as $key => $visibility)
                                <div class="">

                                    <input type="radio" id="teacher{{ $key }}"
                                        class="common-checkbox form-control{{ @$errors->has('visibility') ? ' is-invalid' : '' }}"  name="visibility" value="{{ $key }}"
                                        {{ isset($editdata) ? (($editdata->visibility == $key) ? 'checked':''): ('private'==$key ? 'checked':'')}}
                                        >
                                    <label for="teacher{{ $key }}">
                                        {{ @$visibility }}</label>
                                </div>
                            @endforeach
                            @if ($errors->has('visibility'))
                                <span class="text-danger d-block" >
                                    {{ $errors->first('visibility') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
               
                <div class="row  mt-15">
                    <div class="col-lg-12 mt-15">
                        <div class="primary_input">
                            <div class="primary_file_uploader">
                                <input
                                class="primary_input_field form-control {{ $errors->has('attached_file') ? ' is-invalid' : '' }}"
                                readonly="true" type="text"
                                placeholder="{{ isset($editdata->attached_file) && @$editdata->attached_file != '' ? getFilePath3(@$editdata->attached_file) : 'Attach File ' }}"
                                id="placeholderInput">
                               
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg" for="browseFile">{{ __('common.browse') }}</label>
                                    <input type="file" class="d-none" name="attached_file" id="browseFile">
                                </button>
                            </div>
                            @if ($errors->has('attached_file'))
                            <span class="text-danger d-block" >
                                {{ $errors->first('attached_file') }}
                            </span>
                        @endif
                        </div>
                    </div>
                </div>



                @php
                    $tooltip = '';
                    if (userPermission('g-meet.virtual-meeting.store')) {
                        $tooltip = '';
                    } else {
                        $tooltip = 'You have no permission to add';
                    }
                @endphp
                @if(@gMainSettings()->use_api == 1 && !hasKeySecret())
                 <span class="text-danger">{{ __('gmeet::gmeet.Please sing in first from top') }}</span>
                @else
                <div class="row mt-30">
                    <div class="col-lg-12 text-center">
                        <button class="primary-btn fix-gr-bg submit {{ hasKeySecret() ? 'eventSubmit' :'' }}" data-toggle="tooltip"
                            title="{{ $tooltip }}">
                            <span class="ti-check"></span>
                            @if (isset($editdata))
                                @lang('gmeet::gmeet.update_meeting')
                            @else
                                @lang('gmeet::gmeet.save_meeting')
                            @endif

                        </button>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>
@include('backEnd.partials.multi_select_js')
@include('backEnd.partials.date_picker_css_js')