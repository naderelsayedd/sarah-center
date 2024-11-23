@extends('backEnd.master')
@section('title')
@lang('academics.assign_class_teacher')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Tracking List </h1>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">Tracking List</h3>
                                </div>
                            </div>
                        </div>
                        @if($role_id == 1)
                            {{ Form::open(['class' => 'form-horizontal']) }}
                                <div class="pull-right loader loader_style" id="select_un_student_loader">
                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                <div class="add-visitor"  style="padding-top:20px;">
                                    <div class="row">
                                        <div class="col-lg-4" id="select_driver_div">
                                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                            <select class="primary_select form-control {{ @$errors->has('select_driver') ? ' is-invalid' : '' }}" id="select_driver" name="select_driver">
                                                <option data-display="Select Driver" value="">Select Driver </option>
                                                @foreach($drivers as $driver)
                                               
                                                    <option value="{{ @$driver->id}}">{{ @$driver->full_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('select_driver'))
                                            <span class="text-danger invalid-select" role="alert">
                                                {{ @$errors->first('select_driver') }}
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 pt-2">
                                            <div class="">
                                                <input type="input" id="search_keyword" name="keyword" class="primary_input form-control" placeholder="Search Keyword" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4 pt-2">
                                            <div class="">
                                                <button type="button" id="search_tracks" class="primary-btn white">Search Tracks</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        @endif

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table Crm_table_active3" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Start Address</th>
                                                <th>End Address</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tracking_list">
                                            @if($role_id == 9 && !empty($driver_tracking_list))
                                                @foreach($driver_tracking_list as $track)
                                                    <tr>
                                                        <td valign="top">{{$track->address}}</td>
                                                        <td valign="top">{{$track->address_end}}</td>
                                                        <td valign="top">{{$track->traking_start}}</td>                                            
                                                        <td valign="top">{{$track->traking_end}}</td>                                            
                                                        <td valign="top">
                                                            <a class="dropdown-item" href="{{'driver-route-list/'.$track->id.'/driver'}}">View Map</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script>
        // Include date-fns library
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
            var dayName = d.toLocaleString('en-us', {
                weekday: 'long'
            });
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            return [dayName, day, month, year].join('- ');
        }
        $(document).on("click","#search_tracks", function(){
            var driver_id = $("#select_driver").val();
            var keyword = $("#search_keyword").val();

            var formData = {
                staff_id : driver_id,
                keyword : keyword,
                type : "admin"
            };
            var i = 0;
            if(driver_id != ""){
                $.ajax({
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    url: "ajax-student-driver-traking-list",
                    beforeSend: function() {
                        $('#select_un_student_loader').addClass('pre_loader').removeClass('loader');
                    },
                    success: function(data) {
                        var a = "";
                        $.each(data, function(i, tracking) {
                            var trackingId = tracking.id; // replace with your actual tracking ID
                            var trackingType = 'admin'; 
                            var url = 'driver-route-list/'+trackingId+'/'+trackingType;

                            var info = `<tr>
                                            <td valign="top">`+tracking.address+`</td>
                                            <td valign="top">`+tracking.address_end+`</td>
                                            <td valign="top">`+formatDate(tracking.traking_start)+`</td>                                            
                                            <td valign="top">`+formatDate(tracking.traking_end)+`</td>                                            
                                            <td valign="top">
                                                <a class="dropdown-item" href="`+url+`">View Map</a>
                                            </td>
                                        </tr>`;

                            $("#tracking_list").append(info);
                        });
                    },
                    error: function(data) {
                        console.log("Error:", data);
                    },
                    complete: function() {
                        i--;
                        if (i <= 0) {
                            $('#select_un_student_loader').removeClass('pre_loader').addClass('loader');
                        }
                    }
                });
            }
        });

    </script>
@endpush
