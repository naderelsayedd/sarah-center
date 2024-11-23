@extends('backEnd.master')
@section('title')
@lang('academics.assign_class_teacher')
@endsection
@section('mainContent')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    .map {
        height: 500px;
        width: 100%;
    }
</style>
@endpush

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Tracking Route List </h1>
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
                                    <h3 class="mb-0">Tracking Route List</h3>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right loader loader_style" id="select_un_student_loader">
                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                        </div>
                        @if($type != "parent")
                            <div class="row">
                                <div class="col-lg-6"  style="margin-top:20px;">
                                    <div class="map" id="route_map"></div>
                                </div>
                            </div>
                        @endif
                        <div class="row" id="studentListDiv">
                            <div class="col-lg-6">
                                <div class="add-visitor" style="padding-top:20px;">
                                    <div class="row">
                                        <div class="col-lg-12" id="select_student_div">
                                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                            <select class="primary_select form-control {{ @$errors->has('select_student') ? ' is-invalid' : '' }}" id="select_student" name="select_student" >
                                                <option data-display="Select Student" value="">Select Student </option> 
                                                @foreach($student_traking_list as $student)
                                                    <option value="{{ @$student->student_id}}">{{ @$student->full_name}}</option>
                                                @endforeach                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6"  style="margin-top:20px;">
                                <div  class="map" id="student_map"></div>
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
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>  
    
    <script>

        
        function loadMap(id, coordinates){
            
            console.log("coordinates =>" + coordinates);
            // Create the map
            const map = L.map(id).setView(coordinates[0], 15);

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add markers
            coordinates.forEach(coord => {
                L.marker(coord).addTo(map);
            });

            // Add route
            const polyline = L.polyline(coordinates, {color: 'red'}).addTo(map);

            // Fit map bounds to route
            map.fitBounds(polyline.getBounds());

        }
        const type = "{{ $type }}";
        if(type != "parent"){
            const coordinates = {!! json_encode($coordinates) !!};
            loadMap("route_map", coordinates);            
        }

        $(document).on("change","#select_student", function(){
            var student_id = $(this).val();
            const student_cordinates = {!! json_encode($student_coordinates) !!};
            
            loadMap("student_map", student_cordinates[student_id]);

        });

    </script>
@endpush
