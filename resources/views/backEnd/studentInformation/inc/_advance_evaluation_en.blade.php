<div role="tabpanel" class="tab-pane fade {{ Session::get('advance_evaluation') == 'active' ? 'show active' : '' }}" id="advance_evaluation">
    <div class="white-box">
	
       
        <div class="row">
			<div class="col-12">
			@if(count($studentEvaluation))
				<div class="h3 text-center mb-3">Level change evaluation</div>
				<div class="h4 text-center mb-3">From  
				@if ($student_detail->defaultClass != '')
					{{ @$student_detail->defaultClass->class->class_name }}
                    @elseif ($student_detail->studentRecord != '')
					{{ @$student_detail->studentRecord->class->class_name }}
                    @endif to creators</div>
				<div class="report-table">
					<table class="report-section">
						<thead>
							<tr>
								<th>Sequence</th>
								<th>Clause</th>
								<th>Versed</th>
								<th>To Some Extent</th>
								<th>He couldn't</th>
							</tr>
						</thead>
						<tbody>
							@php 
							$count = 0
							@endphp
							@foreach ($studentEvaluation as $key => $data)
							<tr>
								<td>{{$count + 1}}</td>
								<td>{{$data->evaluation}}</td>
								<td>
									@if($data->versed) 
									Yes 
									@else 
									No 
									@endif
								</td>
								<td>
									@if($data->extend) 
									Yes 
									@else 
									No 
									@endif
								</td>
								<td>
									@if($data->cannot) 
									Yes 
									@else 
									No 
									@endif
								</td>
							</tr>
							@php 
							$count = $count + 1;
							@endphp
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td>
									
									<div class="col-12 info-field"><strong>Teacher Name:</strong> <span>@if(count($studentEvaluation)) {{getStaffName($studentEvaluation[0]->teacher_id)}} @endif</span></div>
									<div class="col-12 info-field"><strong>Date:</strong> <span>@if(count($studentEvaluation)) {{$studentEvaluation[0]->created_at}} @endif</span></div>
									<div class="col-12 info-field"><strong>Result:</strong> <span>@if(count($studentEvaluation) && $studentEvaluation[0]->is_eligible == 1) Eligible to Move @else Ineligible @endif   </span></div>			
									<div class="col-12 info-field"><strong>Director:</strong> <span></span></div>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				@else 
				@if(auth()->user()->role_id == 4) 
				
				{{ Form::open(['class' => 'form-horizontal', 'route' => 'student-teacher-evaluation', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				<div class="h3 text-center mb-3">Level change evaluation</div>
				<div class="h4 text-center mb-3">From buds to creators</div>
				<div class="report-table">
					
					<input type="hidden" name="student_id" value="{{$student_detail->id}}" />
					<input type="hidden" name="parent_id" value="{{$student_detail->parent_id}}" />
					<input type="hidden" name="teacher_id" value="{{Auth::user()->id}}" />
					<input type="hidden" name="role_id" value="4" />
					<table class="report-section">
						<thead>
							<tr>
								<th>Sequence</th>
								<th>Clause</th>
								<th>Versed</th>
								<th>To Some Extent</th>
								<th>He couldn't</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Show curiosity or interest in learning new things <input type="hidden" name="evaluation[1]" value="Show curiosity or interest in learning new things"></td>
								<td><input type="radio" name="versed[1]" id="evaluation_1" value="1"></td>
								<td><input type="radio" name="extend[1]" id="evaluation_1" value="1"></td>
								<td><input type="radio" name="cannot[1]" id="evaluation_1" value="1"></td>
							</tr>
							<tr>
								<td>2</td>
								<td>The ability to explore new things with their senses <input type="hidden" name="evaluation[2]" value="The ability to explore new things with their senses"></td>
								<td><input type="radio" name="versed[2]" id="evaluation_2" value="1"></td>
								<td><input type="radio" name="extend[2]" id="evaluation_2" value="1"></td>
								<td><input type="radio" name="cannot[2]" id="evaluation_2" value="1"></td>
							</tr>
							<tr>
								<td>3</td>
								<td>Take turns and collaborate with peers <input type="hidden" name="evaluation[3]" value="Take turns and collaborate with peers"></td>
								<td><input type="radio" name="versed[3]" id="evaluation_3" value="1"></td>
								<td><input type="radio" name="extend[3]" id="evaluation_3" value="1"></td>
								<td><input type="radio" name="cannot[3]" id="evaluation_3" value="1"></td>
							</tr>
							<tr>
								<td>4</td>
								<td>Take turns and collaborate with peers <input type="hidden" name="evaluation[4]" value="Take turns and collaborate with peers"></td>
								<td><input type="radio" name="versed[4]" id="evaluation_4" value="1"></td>
								<td><input type="radio" name="extend[4]" id="evaluation_4" value="1"></td>
								<td><input type="radio" name="cannot[4]" id="evaluation_4" value="1"></td>
							</tr>
							<tr>
								<td>5</td>
								<td>Following instructions <input type="hidden" name="evaluation[5]" value="Following instructions"></td>
								<td><input type="radio" name="versed[5]" id="evaluation_5" value="1"></td>
								<td><input type="radio" name="extend[5]" id="evaluation_5" value="1"></td>
								<td><input type="radio" name="cannot[5]" id="evaluation_5" value="1"></td>
							</tr>
							<tr>
								<td>6</td>
								<td>Communicate about how they feel<input type="hidden" name="evaluation[6]" value="Communicate about how they feel"></td>
								<td><input type="radio" name="versed[6]" id="evaluation_6" value="1"></td>
								<td><input type="radio" name="extend[6]" id="evaluation_6" value="1"></td>
								<td><input type="radio" name="cannot[6]" id="evaluation_6" value="1"></td>
							</tr>
							<tr>
								<td>7</td>
								<td>Empathy with other children <input type="hidden" name="evaluation[7]" value="Empathy with other children"></td>
								<td><input type="radio" name="versed[7]" id="evaluation_7" value="1"></td>
								<td><input type="radio" name="extend[7]" id="evaluation_7" value="1"></td>
								<td><input type="radio" name="cannot[7]" id="evaluation_7" value="1"></td>
							</tr>
							<tr>
								<td>8</td>
								<td>Impulse control <input type="hidden" name="evaluation[8]" value="Impulse control"></td>
								<td><input type="radio" name="versed[8]" id="evaluation_8" value="1"></td>
								<td><input type="radio" name="extend[8]" id="evaluation_8" value="1"></td>
								<td><input type="radio" name="cannot[8]" id="evaluation_8" value="1"></td>
							</tr>
							<tr>
								<td>9</td>
								<td>Attention <input type="hidden" name="evaluation[9]" value="Attention"></td>
								<td><input type="radio" name="versed[9]" id="evaluation_9" value="1"></td>
								<td><input type="radio" name="extend[9]" id="evaluation_9" value="1"></td>
								<td><input type="radio" name="cannot[9]" id="evaluation_9" value="1"></td>
							</tr>
							<tr>
								<td>10</td>
								<td>Reducing disruptive behaviors <input type="hidden" name="evaluation[10]" value="Reducing disruptive behaviors"></td>
								<td><input type="radio" name="versed[10]" id="evaluation_10" value="1"></td>
								<td><input type="radio" name="extend[10]" id="evaluation_10" value="1"></td>
								<td><input type="radio" name="cannot[10]" id="evaluation_10" value="1"></td>
							</tr>
						</tbody>
					</table>
					
				</div>
				<div class="table-footer mt-6 row">
					<div class="col-12 info-field"><strong>Result:</strong> <span><input type="radio" name="is_eligible" id="is_eligible" value="1"> Eligible to Move  <input type="radio" name="is_eligible" id="is_eligible" value="0"> Ineligible   </span></div>
				</div>
				
				<div class="col-lg-12 mt-20 text-right">
					<button type="submit" class="primary-btn small fix-gr-bg">
						@lang('common.submit')
					</button>
				</div>
				
				{{ Form::close() }}
				@endif
				@endif
			</div>
		</div>
	</div>
</div>
