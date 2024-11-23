<div class="row">
	<div class="col-lg-12">
		<div class="white-box">
			<div class="col-lg-12">
				<div class="main-title">
					<h3>@lang('dashboard.weekly_plan')</h3>
					
					<div class="col-lg-12 text-right">
						<a href="#" class="primary-btn small fix-gr-bg" data-toggle="modal" data-target="#exampleModal"><span class="ti-plus pr-2"></span>@lang('dashboard.add_time_slot')</a>
					</div>
				<?php if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5): ?>
					<div class="col-lg-6 mb-4">
						<form action="{{ route('dashboard') }}" method="get" id="teacher-filter-form">
							<select class="nice-select primary_select form-control" name="filter_teacher_id" onchange="document.getElementById('teacher-filter-form').submit()">
								<option selected disabled>@lang('dashboard.filter_by_teacher')</option>
								<?php foreach ($staff_list as $key => $value):?>
				                <option value="{{$value->user_id}}" {{ request()->get('filter_teacher_id') == $value->user_id? 'selected' : '' }}>{{$value->full_name}}</option>
								<?php endforeach?>
							</select>
						</form>
					</div>
					<?php endif ?>
				</div>
			</div>
			<br>
			<br>
			<div class="col-lg-12">
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th>@lang('dashboard.time')</th>
							@for ($i = 0; $i < count($lessionData['sm_weekends']); $i++)
							<th>
								{{ HijriDateFormat($lessionData['dates'][$i]) }}
								<br>
								{{ date('l', strtotime($lessionData['dates'][$i])) }}
							</th>
							@endfor
						</tr>
					</thead>
					<tbody>
						@php
						$tr = [];
						@endphp
						@foreach ($lessionData['sm_weekends'] as $sm_weekend)
						@php
						$teacherClassRoutineById = App\SmWeekend::teacherClassRoutineById($sm_weekend->id, $lessionData['teacher_id']);
						@endphp
						@foreach ($teacherClassRoutineById as $routine)
						@php
						$startTime = $routine->start_time;
						if (!isset($tr[$startTime])) {
						$tr[$startTime] = [];
						}
						$tr[$startTime][$sm_weekend->name][] = [
						'routine_id' => $routine->id,
						'lesson_date' => $sm_weekend->date,
						'subject' => $routine->subject,
						'class_id' => $routine->class_id,
						'section_id' => $routine->section_id,
						'class_name' => $routine->class->class_name,
						'class_room' => $routine->classRoom->room_no,
						'subject_code' => $routine->subject->subject_code,
						'subject_id' => $routine->subject->id,
						'section_name' => $routine->section? $routine->section->section_name : '',
						'start_time' => $routine->start_time,
						'end_time' => $routine->end_time,
						'is_break' => $routine->is_break,
						];
						@endphp
						@endforeach
						@endforeach
						@php
						ksort($tr);
						@endphp
						
						@foreach ($tr as $startTime => $routines)
						<tr>
							<td>{{HijriTimeFormat(date('h:i A', strtotime($startTime)))}} - {{HijriTimeFormat(date('h:i A', strtotime($startTime) + 60 * 60))}}</td>
							@foreach ($lessionData['sm_weekends'] as $sm_weekend)
							<td>
								@if (isset($routines[$sm_weekend->name]))
								@foreach ($routines[$sm_weekend->name] as $r)
								
								<?php 
									
									$lessonPlan = Modules\Lesson\Entities\LessonPlanner::where('lesson_date',$lessionData['dates'][$loop->parent->index])
									->where('class_id',$r['class_id'])
									->where('section_id',$r['section_id'])
									->where('subject_id',$r['subject_id'])
									->where('routine_id',$r['routine_id'])
									->where('academic_id', getAcademicId())
									->where('school_id',Auth::user()->school_id)
									->first();
									
									
									
								?>
								@if ($r['is_break'])
								<strong>Break</strong>
								@else
								<!--<span>{{ $r['class_name'] }}</span>
									<span>{{ $r['class_room'] }} ({{ $r['subject_code'] }}) - {{ $r['section_name'] }}</span>
									<br>
								<strong>Room:</strong><span>{{ $r['class_room'] }}</span><br>-->
								@if($lessonPlan)
								<?php $lessonPlanDetail = Modules\Lesson\Entities\LessonPlanner::find($lessonPlan->id); ?>
								<strong>@lang('common.subject'):</strong>
								<span>
									@if(moduleStatusCheck('University'))
									{{$lessonPlanDetail->unSubject->subject_name}} ({{$lessonPlanDetail->unSubject->subject_code}}) -{{$lessonPlanDetail->unSubject->subject_type}}
									@else
									{{$lessonPlanDetail->subject->subject_name}} ({{$lessonPlanDetail->subject->subject_code}}) -{{$lessonPlanDetail->subject->subject_type == 'T'? 'Theory':'Practical'}}
									@endif
								</span>
								<br>
								
								<strong>@lang('lesson::lesson.lesson'):</strong>
								<span>
									{{$lessonPlanDetail->lessonName->lesson_title}}
								</span>
								<br>
								
								<strong>@lang('common.topic'):</strong>
								<span>
									@if(count($lessonPlanDetail->topics) > 0) 
									@foreach ($lessonPlanDetail->topics as $topic)
									{{$topic->topicName->topic_title}}  {{!$loop->last ? ',':'' }}
									@endforeach
									@else  
									{{$lessonPlanDetail->topicName->topic_title}}
									@endif
								</span>
								<br>
								
								@endif
								<span>{{ HijriTimeFormat(date('h:i A', strtotime($r['start_time']))) }}-{{ HijriTimeFormat(date('h:i A', strtotime($r['end_time']))) }} <span class="ti-pencil" onclick="getClassRoutineTimeSlot({{$r['routine_id']}})" style="cursor:pointer; padding: 5px;"></span></span>
								<br>
								
								
								@if($lessonPlan)
								<div style="display:inline-flex;">
									@if(userPermission('view-lesson-planner-lesson'))
									<div>
										<a href="{{route('view-lesson-planner-lesson', [$lessonPlan->id])}}"
										class="primary-btn small tr-bg icon-only modalLink"
										title="@lang('lesson::lesson.lesson_overview') " data-modal-size="modal-lg">
											<span class="ti-eye" id=""></span>
										</a>
									</div>
									@endif
									@if(userPermission('delete-lesson-planner-lesson'))
									<div>
										<a href="{{route('delete-lesson-planner-lesson', [$lessonPlan->id])}}"
										class="primary-btn small tr-bg icon-only  modalLink"
										data-modal-size="modal-md"
										title="@lang('lesson::lesson.delete_lesson_plan')">
											<span class="ti-close" id=""></span>
										</a>
									</div>
									@endif
									@if(userPermission('edit-lesson-planner-lesson'))
									<div>
										<a href="{{route('edit-lesson-planner-lesson', [$lessonPlan->id])}}"
										class="primary-btn small tr-bg icon-only mr-10 modalLink"
										data-modal-size="modal-lg"
										title="@lang('lesson::lesson.add_lesson_plan') {{date('d-M-y',strtotime($lessionData['dates'][$loop->parent->index]))}} ( {{date('h:i A', strtotime(@$r['start_time']))}}-{{date('h:i A', strtotime(@$r['end_time']))}} )">
											<span class="ti-pencil" id=""></span>
										</a>
									</div>
									@endif
								</div>
								@else
								<div class="col-lg-12 p-0 text-center">
									<a href="{{route('add-lesson-planner-lesson', [
									$sm_weekend->id,
									$lessionData['teacher_id'],
									$r['routine_id'],
									$lessionData['dates'][$loop->parent->index]
									])}}"
									class="primary-btn small tr-bg icon-only mr-10 modalLink"
									data-modal-size="modal-lg"
									title="@lang('lesson::lesson.add_lesson_plan') {{date('d-M-y',strtotime($lessionData['dates'][$loop->parent->index]))}} ( {{date('h:i A', strtotime(@$r['start_time']))}}-{{date('h:i A', strtotime(@$r['end_time']))}} )">
										<span class="ti-plus" id="addClassRoutine"></span>
									</a>
								</div>
								@endif
								@endif
								@endforeach
								@else
								
								<!-- <a href="#" data-toggle="modal" data-target="#exampleModal"><span class="ti-plus" id="addClassRoutine"></span></a> -->
								@endif
							</td>
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
				
				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">@lang('common.add_time_slot')	</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form class="form-group" action="{{ route('save-class-routine') }}" method="post">
									@csrf
									<div class="form-group">
										<input type="hidden" name="teacher_id" value="{{(request()->get('filter_teacher_id'))?request()->get('filter_teacher_id'):120}}">
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="images">@lang('common.class'):</label>
												<select class="form-control" name="class_id" id="Weeklyclass_id">
													<option selected disabled>@lang('common.class')</option>
													<?php foreach ($allClasses as $key => $value): ?>
													<option value="{{$value->id}}">{{$value->class_name}}</option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="images">@lang('common.section'):</label>
												<select class="form-control" id="section_id" name="section_id">
													<option selected disabled>@lang('common.select_section')</option>
												</select>
											</div>
										</div>
									</div>
									
									
									<div class="form-group">
										<label for="images">@lang('common.days'): <small><input type="checkbox" name="checkAll" class="checkAll">@lang('common.all_days')</small></label><br>
										
										<input type="checkbox" name="day_ids[]" class="checkboxes" value="2" > @lang('common.Sunday') <br>
										<input type="checkbox" name="day_ids[]" class="checkboxes" value="3" > @lang('common.Monday') <br>
										<input type="checkbox" name="day_ids[]" class="checkboxes" value="4" > @lang('common.Tuesday') <br>
										<input type="checkbox" name="day_ids[]" class="checkboxes" value="5" > @lang('common.Wednesday') <br>
										<input type="checkbox" name="day_ids[]" class="checkboxes" value="6" > @lang('common.Thursday') <br>
									</div>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label>@lang('common.start_time'):</label>
												<input type="time" name="start_time" class="form-control">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>@lang('common.end_time'):</label>
												<input type="time" name="end_time" class="form-control">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="images">@lang('common.subject'):</label>
												<select class="form-control" name="subject_id" id="Weeklyclass_id">
													<option selected disabled>@lang('common.select_subject')</option>
													<?php foreach ($subject_list as $key => $value): ?>
													<option value="{{$value->id}}">{{$value->subject_name}}</option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="images">@lang('common.room'):</label>
												<select class="form-control fix-gr-bg" name="class_room">
													<option selected disabled>@lang('common.select_room')</option>
													<?php foreach ($class_rooms_list as $key => $value):?>
													<option value="{{$value->id}}">{{$value->room_no}}</option>
													<?php endforeach?>
												</select>
											</div>
										</div>
									</div>
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
									<button type="submit" class="btn btn-primary">@lang('common.save')</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				
				<!-- Modal -->
				<div class="modal fade" id="updateTimeSlot" tabindex="-1" role="dialog" aria-labelledby="updateTimeSlotLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="updateTimeSlotLabel">Update Time Slot</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form class="form-group" action="{{ route('upadte-class-routine-time') }}" method="post">
									@csrf
									<div id="updateTimeSlotDiv">
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Save changes</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<script>
	
	function getClassRoutineTimeSlot(id){
			$.ajax({
				type: 'GET',
				url: "{{ route('get-class-routine-time') }}",
				data: {routine_id: id},
				success: function(data) {
					$('#updateTimeSlotDiv').html(data);
					$('#updateTimeSlot').modal('show');
				}
			});
		}
	
	$(document).ready(function() {
		$('#Weeklyclass_id').on('change', function() {
			var class_id = $(this).val();
			$.ajax({
				type: 'GET',
				url: "{{ route('get-class-section') }}",
				data: {class_id: class_id},
				success: function(data) {
					$('#section_id').empty();
				$('#section_id').append(data);
				}
			});
		});
		
		
		
		$(function(){
			$('.checkAll').click(function(){
				if (this.checked) {
					$(".checkboxes").prop("checked", true);
					} else {
					$(".checkboxes").prop("checked", false);
				}	
			});
			
			$(".checkboxes").click(function(){
				var numberOfCheckboxes = $(".checkboxes").length;
				var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
				if(numberOfCheckboxes == numberOfCheckboxesChecked) {
					$(".checkAll").prop("checked", true);
					} else {
					$(".checkAll").prop("checked", false);
				}
			});
		});
		
	});
</script>		