@extends('backEnd.master')
@section('title')
@lang('subscription_plan')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('subscription.subscription_plan') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('subscription.subscription')</a>
                <a href="#">@lang('subscription.subscription_plan') </a>
			</div>
		</div>
	</div>
</section>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="white-box">
                <h1 class="mb-4">@lang('subscription.create_subscription')</h1>
                <form action="{{ route('subscription-plans.store') }}" method="POST" class="needs-validation" novalidate id="create-subscription-plan-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">@lang('subscription.name') <span	class="text-danger"> *</span></label>
                        <input type="text" id="name" name="name" class="form-control" required>
					</div>
					
					<div class="form-group">
						<label class="primary_input_label" for="">@lang('front_settings.course_category') <span	class="text-danger"> *</span></label>
						<select	class="form-control" name="category_id" onchange="getSubCategories(this.value)">
							<option value="">@lang('common.select') *</option>
							@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->category_name }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label class="primary_input_label" for="">@lang('front_settings.course_section') <span class="text-danger"> *</span></label>
						<select id="course_section" class="form-control mb-30 course_section" name="course_section">
							<option value="">@lang('common.select') *</option>
							@foreach($courseSection as $sections)
							<option value="{{$sections->id}}">{{$sections->category_name}}</option>
							@endforeach
						</select>
					</div>
					
                    <div class="form-group">
                        <label for="name">@lang('subscription.type'):</label>
                        <select class="form-control" name="type">
                            <option selected disabled>@lang('subscription.select_type')</option>
                            <option value="1">@lang('subscription.bus_service_addon')</option>
                            <option value="2">@lang('subscription.registration')</option>
						</select>
					</div>
                    <div class="form-group">
                        <label for="description">@lang('subscription.description'):</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
					</div>
					
					
                    <div class="form-group">
                        <label for="price">@lang('subscription.price'):</label>
                        <input type="number" id="price" name="price" class="form-control" required>
					</div>
					<div class="form-group">
                        <label for="name">@lang('subscription.grace_period') <span	class="text-danger"> *</span></label>
                        <input type="text" id="grace_period" name="grace_period" class="form-control" required>
					</div>
					<div class="form-group">
                        <label for="name">@lang('subscription.number_of_student') <span	class="text-danger"> *</span></label>
                        <input type="text" id="number_of_student" name="number_of_student" class="form-control" required value="1">
					</div>
					<div class="form-group">
						<label for="offer">@lang('subscription.offer'):</label>
						<select id="offer" name="offer" class="form-control" required>
							<option value="">@lang('subscription.select_offer')</option>
							<option value="1">@lang('subscription.yes')</option>
							<option value="2">@lang('subscription.no')</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="offer">@lang('subscription.other_offers'):</label>
						<select id="offer" name="other_offers" class="form-control" required>
							<option value="0">@lang('subscription.select_other_offers')</option>
							<option value="1">@lang('subscription.offer_type_1')</option>
							<option value="2">@lang('subscription.offer_type_2')</option>
						</select>
					</div>
					
                    <div class="form-group">
						<label for="duration">@lang('subscription.duration'):</label>
						<select name="duration-type" class="form-control" required>
							<option value="">@lang('subscription.select_duration_type')</option>
							<option value="1">@lang('subscription.yearly')</option>
							<option value="2">@lang('subscription.half_year')</option>
							<option value="3">@lang('subscription.quarterly')</option>
							<option value="4">@lang('subscription.monthly')</option>
							<option value="6">@lang('subscription.weekly')</option>
							<option value="5">@lang('subscription.days')</option>
							
						</select>
					</div>
                    <button type="submit" class="btn btn-primary">@lang('subscription.create_subscription_plan')</button>
				</form>
			</div>
		</div>
        <div class="col-sm-9">
            <div class="white-box">
                <h1 class="mb-4">@lang('subscription.subscription_plans')</h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('subscription.name')</th>
							<th>@lang('subscription.categories')</th>
                            <th>@lang('subscription.type')</th>
                            <th>@lang('subscription.description')</th>
                            <th>@lang('subscription.price')</th>
							<th>@lang('subscription.grace_period')</th>
							<th>@lang('subscription.offer')</th>
                            <!--<th>@lang('subscription.duration')</th>-->
                            <th>@lang('subscription.actions')</th>
						</tr>
					</thead>
                    <tbody>
                        @foreach($subscriptionPlans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
							<td>{{ $plan->courseCategory->category_name }} ({{$plan->sectionClass->category_name}}) </td>
                            <td>
                                <?php if ($plan->type == 1) { ?>
                                    @lang('subscription.bus_service_addon')
									<?php }else if($plan->type == 2){ ?>
                                    @lang('subscription.registration')
								<?php } ?>
							</td>
                            <td>{{ $plan->description }}</td>
                            <td>{{ $plan->price }}</td>
							<td>{{ $plan->grace_period }}</td>
							<td>
								<?php if ($plan->offer == 1) { ?>
                                    @lang('subscription.yes')
									<?php }else if($plan->offer == 2){ ?>
                                    @lang('subscription.no')
								<?php } ?>
							</td>
                            <!--<td>
                                <?php if ($plan->duration_type == 1) {
                                    echo "Yearly";
									}else if($plan->duration_type == 2){
                                    echo "Half Yearly";
									}else if($plan->duration_type == 3){
                                    echo "Quarterly";
									} else if($plan->duration_type == 4){
                                    echo "Monthly";
									} else if($plan->duration_type == 6){
                                    echo "Weekly";
									} else if($plan->duration_type == 5){
                                    echo "Days";
								} ?>
							</td>-->
                            <td>
                                <a href="#" class="primary-btn small fix-gr-bg edit-plan" data-plan-id="{{ $plan->id }}">@lang('subscription.edit')</a>
                                <form action="{{ route('subscription-plans.delete', $plan->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger-btn small fix-gr-bg">@lang('subscription.delete')</button>
								</form>
							</td>
						</tr>
                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Edit Subscription Plan Modal -->
<div class="modal fade" id="edit-subscription-plan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('subscription.edit_subscription_plan')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
                <form action="" method="POST" class="needs-validation" novalidate id="edit-subscription-plan-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">@lang('subscription.name'):</label>
                        <input type="text" id="name" name="name" class="form-control" required>
					</div>
					
					<div class="form-group">
						<label class="primary_input_label" for="">@lang('front_settings.course_category') <span	class="text-danger"> *</span></label>
						<select	class="form-control" name="category_id" id="category_id" onchange="getSubCategories(this.value)">
							<option value="">@lang('common.select') *</option>
							@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->category_name }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label class="primary_input_label" for="">@lang('front_settings.course_section') <span class="text-danger"> *</span></label>
						<select id="course_section" class="form-control mb-30 course_section" name="course_section">
							<option value="">@lang('common.select') *</option>
							@foreach($courseSection as $sections)
							<option value="{{$sections->id}}">{{$sections->category_name}}</option>
							@endforeach
						</select>
					</div>
					
                    <div class="form-group">
                        <label for="name">@lang('subscription.type'):</label>
                        <select id="type" class="form-control" name="type">
                            <option selected disabled>@lang('subscription.select_type')</option>
                            <option value="1">@lang('subscription.bus_service_addon')</option>
                            <option value="2">@lang('subscription.registration')</option>
						</select>
					</div>
                    <div class="form-group">
                        <label for="description">@lang('subscription.description'):</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
					</div>
                    <div class="form-group">
                        <label for="price">@lang('subscription.price'):</label>
                        <input type="number" id="price" name="price" class="form-control" required>
					</div>
					
					<div class="form-group">
                        <label for="name">@lang('subscription.grace_period') <span	class="text-danger"> *</span></label>
                        <input type="text" id="grace_period" name="grace_period" class="form-control" required>
					</div>
					<div class="form-group">
                        <label for="name">@lang('subscription.number_of_student') <span	class="text-danger"> *</span></label>
                        <input type="text" id="number_of_student" name="number_of_student" class="form-control" required value="1">
					</div>
					<div class="form-group">
						<label for="offer">@lang('subscription.offer'):</label>
						<select id="offer" name="offer" class="form-control" required>
							<option value="">@lang('subscription.select_offer')</option>
							<option value="1">@lang('subscription.yes')</option>
							<option value="2">@lang('subscription.no')</option>
						</select>
					</div>
					<div class="form-group">
						<label for="other_offers">@lang('subscription.other_offers'):</label>
						<select id="other_offers" name="other_offers" class="form-control" required>
							<option value="0">@lang('subscription.select_other_offers')</option>
							<option value="1">@lang('subscription.offer_type_1')</option>
							<option value="2">@lang('subscription.offer_type_2')</option>
						</select>
					</div>
                    <div class="form-group">
						<label for="duration">@lang('subscription.duration'):</label>
						<select id="duration-type" name="duration-type" class="form-control" required>
							<option value="">@lang('subscription.select_duration_type')</option>
							<option value="1">@lang('subscription.yearly')</option>
							<option value="2">@lang('subscription.half_year')</option>
							<option value="3">@lang('subscription.quarterly')</option>
							<option value="4">@lang('subscription.monthly')</option>
							<option value="6">@lang('subscription.weekly')</option>
							<option value="5">@lang('subscription.days')</option>
						</select>
					</div>
                    <button type="submit" class="btn btn-primary">@lang('subscription.update_scription_plan')</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('.full-page-loader').show();
        $('.edit-plan').on('click', function(e) {
            e.preventDefault();
            var planId = $(this).data('plan-id');
            $('#edit-subscription-plan-modal').modal('show');
            $('.preloader').show();
		$.ajax({
		type: 'GET',
		url: '{{ route('subscription-plans.show', '') }}/' + planId,
		success: function(data) {
		$('#edit-subscription-plan-form').find('input[name="name"]').val(data.name);
		$('#edit-subscription-plan-form').find('textarea[name="description"]').val(data.description);
		$('#edit-subscription-plan-form').find('input[name="price"]').val(data.price);
		$('#edit-subscription-plan-form').find('input[name="number_of_student"]').val(data.price);
		$('#edit-subscription-plan-form').find('input[name="grace_period"]').val(data.price);
		// Show the selected duration
		$('#edit-subscription-plan-form #duration-type').val(data.duration_type);
		$('#edit-subscription-plan-form #duration-type option[value="' + data.duration_type + '"]').prop('selected', true);
		// Show the selected duration
		$('#edit-subscription-plan-form #category_id').val(data.category_id);
		$('#edit-subscription-plan-form #category_id option[value="' + data.category_id + '"]').prop('selected', true);
		
		$('#edit-subscription-plan-form #course_section').val(data.course_section);
		$('#edit-subscription-plan-form #course_section option[value="' + data.course_section + '"]').prop('selected', true);
		
		$('#edit-subscription-plan-form #offer').val(data.offer);
		$('#edit-subscription-plan-form #offer option[value="' + data.offer + '"]').prop('selected', true);
		
		$('#edit-subscription-plan-form #other_offers').val(data.other_offers);
		$('#edit-subscription-plan-form #other_offers option[value="' + data.other_offers + '"]').prop('selected', true);
		
		
		// Show the selected duration
		$('#edit-subscription-plan-form #type').val(data.type);
		$('#edit-subscription-plan-form #type option[value="' + data.type + '"]').prop('selected', true);
		$('#edit-subscription-plan-form').attr('action', '{{ route('subscription-plans.update', '') }}/' + planId);
		$('.preloader').hide();
		}
		});
		});
		
		
		});
		function getSubCategories(main_category, selected_category = '') {
		var formData = {
		main_category: main_category,
		selected_category: selected_category,
		}
		$.ajax({
		type: "POST",
		data: formData,
		dataType: "html",
		url: "{{ route('get-sub-categories') }}",
		success: function(data) {
		$('.course_section').html(data).trigger('change');
		},
		error: function(data) {
		console.log("Error:", data);
		}
		
		})
		}
		</script>
		@endsection		