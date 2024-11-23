<div role="tabpanel" class="tab-pane fade " id="transportation">
    <div class="white-box">
        {{--        <h4 class="stu-sub-head">@lang('student.personal_info')</h4>--}}

        <!-- Start Transport Part -->
        @if(isMenuAllowToShow('transport') || isMenuAllowToShow('dormitory'))

            <!-- <h4 class="stu-sub-head mt-40">@lang('student.'.(isMenuAllowToShow('transport')? 'transport' : ''). (isMenuAllowToShow('transport') && isMenuAllowToShow('dormitory')? '_and_' : '').(isMenuAllowToShow('dormitory')? 'dormitory' : '').'_info')</h4> -->

            <h4 class="stu-sub-head mt-40">Transportation</h4>
            @if(isMenuAllowToShow('transport'))
                @if (is_show('route'))
                    @if (!empty($student_detail->route_list_id))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.route')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ isset($student_detail->route_list_id) ? @$student_detail->route->title : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <!-- @if (is_show('vehicle'))
                    @if (isset($student_detail->vehicle))
                        @if (!empty($vehicle_no))
                            <div class="single-info">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5">
                                        <div class="">
                                            @lang('student.vehicle_number')
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-6">
                                        <div class="">
                                            {{ $student_detail->vehicle != '' ? @$student_detail->vehicle->vehicle_no : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endif
                @endif -->


                @if (isset($driver_info))
                    @if (!empty($driver_info->full_name))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.driver_name')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ $student_detail->vechile_id != '' ? @$driver_info->full_name : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endif

                @if (isset($driver_info))
                    @if (!empty($driver_info->mobile))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.driver_phone_number')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ $student_detail->vechile_id != '' ? @$driver_info->mobile : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if (isset($vehicle_info))
                    @if (!empty($vehicle_info->vehicle_no))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.vehicle_number')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ $student_detail->vechile_id != '' ? @$vehicle_info->vehicle_no : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if (isset($vehicle_info))
                    @if (!empty($vehicle_info->vehicle_model))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.vehicle_model')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ $student_detail->vechile_id != '' ? @$vehicle_info->vehicle_model : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if (isset($vehicle_info))
                    @if (!empty($vehicle_info->made_year))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.vehicle_made_year')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ $student_detail->vechile_id != '' ? @$vehicle_info->made_year : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endif

            <!-- @if (is_show('dormitory_name') && isMenuAllowToShow('dormitory'))
                @if (isset($student_detail->dormitory))
                    @if (!empty($student_detail->dormitory->dormitory_name))
                        <div class="single-info">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="">
                                        @lang('student.dormitory_name')
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="">
                                        {{ isset($student_detail->dormitory_id) ? @$student_detail->dormitory->dormitory_name : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endif -->

        @endif

        <!-- End Transport Part -->
        @if (is_show('custom_field'))
            {{-- Custom field start --}}
            @include('backEnd.customField._coutom_field_show')
            {{-- Custom field end --}}
        @endif
    </div>
</div>
