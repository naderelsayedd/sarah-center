<div role="tabpanel" class="tab-pane fade {{ Session::get('advance_evaluation') == 'active' ? 'show active' : '' }}" id="advance_evaluation">
    <div class="white-box">
		@php
		$certificate = App\SmStudentCertificate::find(5);
		@endphp
		
		
        <div class="row">
			<div class="col-12">
				@if(count($studentEvaluation))
				<div class="h3 text-center mb-3">تقييم تغيير المستوى</div>
				<div class="h4 text-center mb-3">من  
				@if ($student_detail->defaultClass != '')
					{{ @$student_detail->defaultClass->class->class_name }}
                    @elseif ($student_detail->studentRecord != '')
					{{ @$student_detail->studentRecord->class->class_name }}
                    @endif للمبدعين</div>
				<div class="report-table">
					<table class="report-section" dir="rtl">
						<thead>
							<tr>
								<th>التسلسل</th>
								<th>البند</th>
								<th>متمكن</th>
								<th>إلى حد ما</th>
								<th>لم يتمكن</th>
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
									
									<div class="col-12 info-field"><strong>معلمة الصف:</strong> <span>@if(count($studentEvaluation)) {{getStaffName($studentEvaluation[0]->teacher_id)}} @endif</span></div>
									<div class="col-12 info-field"><strong>التاريخ:</strong> <span>@if(count($studentEvaluation)) {{$studentEvaluation[0]->created_at}} @endif</span></div>
									<div class="col-12 info-field"><strong>النتيجة:</strong> <span>@if(count($studentEvaluation) && $studentEvaluation[0]->is_eligible == 1) مؤهلة للتحرك @else غير مؤهل @endif   </span></div>			
									<div class="col-12 info-field"><strong>المديرة:</strong> <span></span></div>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
				@else 
				@if(auth()->user()->role_id == 4) 
				{{ Form::open(['class' => 'form-horizontal', 'route' => 'student-teacher-evaluation', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				<div class="h3 text-center mb-3">تقييم تغيير المستوى</div>
				<div class="h4 text-center mb-3">من البراعم إلى المبدعون</div>
				<div class="report-table">
					
					<input type="hidden" name="student_id" value="{{$student_detail->id}}" />
					<input type="hidden" name="parent_id" value="{{$student_detail->parent_id}}" />
					<input type="hidden" name="teacher_id" value="{{Auth::user()->id}}" />
					<input type="hidden" name="role_id" value="4" />
					<table class="report-section" dir="rtl">
						<thead>
							<tr>
								<th>التسلسل</th>
								<th>البند</th>
								<th>متمكن</th>
								<th>إلى حد ما</th>
								<th>لم يتمكن</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>إظهار الفضول أو الاهتمام بتعلم أشياء جديدة <input type="hidden" name="evaluation[1]" value="Show curiosity or interest in learning new things"></td>
								<td><input type="radio" name="versed[1]" id="evaluation_1" value="1"></td>
								<td><input type="radio" name="extend[1]" id="evaluation_1" value="1"></td>
								<td><input type="radio" name="cannot[1]" id="evaluation_1" value="1"></td>
							</tr>
							<tr>
								<td>2</td>
								<td>القدرة على استكشاف أشياء جديدة بحواسهم <input type="hidden" name="evaluation[2]" value="The ability to explore new things with their senses"></td>
								<td><input type="radio" name="versed[2]" id="evaluation_2" value="1"></td>
								<td><input type="radio" name="extend[2]" id="evaluation_2" value="1"></td>
								<td><input type="radio" name="cannot[2]" id="evaluation_2" value="1"></td>
							</tr>
							<tr>
								<td>3</td>
								<td>التناوب والتعاون مع أقرانهم <input type="hidden" name="evaluation[3]" value="Take turns and collaborate with peers"></td>
								<td><input type="radio" name="versed[3]" id="evaluation_3" value="1"></td>
								<td><input type="radio" name="extend[3]" id="evaluation_3" value="1"></td>
								<td><input type="radio" name="cannot[3]" id="evaluation_3" value="1"></td>
							</tr>
							<tr>
								<td>4</td>
								<td>التحدث واالاستماع إلى أقرانهم والبالغين <input type="hidden" name="evaluation[4]" value="Take turns and collaborate with peers"></td>
								<td><input type="radio" name="versed[4]" id="evaluation_4" value="1"></td>
								<td><input type="radio" name="extend[4]" id="evaluation_4" value="1"></td>
								<td><input type="radio" name="cannot[4]" id="evaluation_4" value="1"></td>
							</tr>
							<tr>
								<td>5</td>
								<td>اتباع التعليمات <input type="hidden" name="evaluation[5]" value="Following instructions"></td>
								<td><input type="radio" name="versed[5]" id="evaluation_5" value="1"></td>
								<td><input type="radio" name="extend[5]" id="evaluation_5" value="1"></td>
								<td><input type="radio" name="cannot[5]" id="evaluation_5" value="1"></td>
							</tr>
							<tr>
								<td>6</td>
								<td>التواصل حول كيف يشعرون <input type="hidden" name="evaluation[6]" value="Communicate about how they feel"></td>
								<td><input type="radio" name="versed[6]" id="evaluation_6" value="1"></td>
								<td><input type="radio" name="extend[6]" id="evaluation_6" value="1"></td>
								<td><input type="radio" name="cannot[6]" id="evaluation_6" value="1"></td>
							</tr>
							<tr>
								<td>7</td>
								<td>التعاطف مع الأطفال الآخرين <input type="hidden" name="evaluation[7]" value="Empathy with other children"></td>
								<td><input type="radio" name="versed[7]" id="evaluation_7" value="1"></td>
								<td><input type="radio" name="extend[7]" id="evaluation_7" value="1"></td>
								<td><input type="radio" name="cannot[7]" id="evaluation_7" value="1"></td>
							</tr>
							<tr>
								<td>8</td>
								<td>السيطرة على الدوافع <input type="hidden" name="evaluation[8]" value="Impulse control"></td>
								<td><input type="radio" name="versed[8]" id="evaluation_8" value="1"></td>
								<td><input type="radio" name="extend[8]" id="evaluation_8" value="1"></td>
								<td><input type="radio" name="cannot[8]" id="evaluation_8" value="1"></td>
							</tr>
							<tr>
								<td>9</td>
								<td>الانتباه <input type="hidden" name="evaluation[9]" value="Attention"></td>
								<td><input type="radio" name="versed[9]" id="evaluation_9" value="1"></td>
								<td><input type="radio" name="extend[9]" id="evaluation_9" value="1"></td>
								<td><input type="radio" name="cannot[9]" id="evaluation_9" value="1"></td>
							</tr>
							<tr>
								<td>10</td>
								<td>الحد من السلوكيات التخريبية <input type="hidden" name="evaluation[10]" value="Reducing disruptive behaviors"></td>
								<td><input type="radio" name="versed[10]" id="evaluation_10" value="1"></td>
								<td><input type="radio" name="extend[10]" id="evaluation_10" value="1"></td>
								<td><input type="radio" name="cannot[10]" id="evaluation_10" value="1"></td>
							</tr>
						</tbody>
					</table>
					
				</div>
				<div class="table-footer mt-6 row">
					<div class="col-12 info-field"><strong>النتيجة:</strong> <span><input type="radio" name="is_eligible" id="is_eligible" value="1"> مؤهلة للتحرك  <input type="radio" name="is_eligible" id="is_eligible" value="0"> غير مؤهل   </span></div>
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
