<div role="tabpanel" class="tab-pane fade" id="certificate">
    <div class="white-box">
		@php
		$certificate = App\SmStudentCertificate::find(5);
		@endphp
		<style rel="stylesheet">
			body{
			font-family: 'dejavu sans','Poppins', sans-serif;
			font-size: 14px;
			margin: 0;
			padding: 0;
			}
			
			.tdWidth{
			width: 33.33%;
			}
			.bgImage{
			height:auto; 
			background-repeat:no-repeat;
			background-image: url({{asset($certificate->file)}});
			
			}
			table{
			/* margin-top: 160px; */
			text-align: center; 
			color: #000;
			}
			
			td{
			padding: 25px !important;
			}
			.DivBody{    
			height: 100vh;
			border: 1px solid var(--border_color) !important;
			margin-top: 0px;
			}
			.tdBody{
			text-align: justify !important;				
			height: 140px;
			padding-top: 0px;
			padding-bottom: 0px;
			padding-left: 65px;
			padding-right: 65px;
			
			}
			img{
			position: absolute;
			}
			table{
			position: relative;
			/* top:100;			 */
			}
			body{
			/* padding:0px !important; */
			margin:0px !important;
			}
			/* style added  */
			.DivBody{
			position: relative;
			}
			.position_bg{
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			}
			.certificate_body_inner {
			/* display: flex;
			flex-direction: column;
			justify-content: space-between;
			height: 100%;
			padding: 120px 0 120px 0; */
			position: relative;
			height: 100%;
			}
			.tdBody {
			position: relative;
			top: 280px;
			}
			
			.postion_header_certificate {
			position: absolute;
			width: calc(100% - 20%);
			left: 0;
			margin: auto;
			right: 0;
			}
			.postion_footer_certificate {
			position: absolute;
			bottom: 15%;
			width: calc(100% - 20%);
			left: 0;
			margin: auto;
			right: 0;
			}
			@page { 
			margin: 2px; 
			size: 21cm 17cm; 
			}
			
			body { margin: 1px; }
			
			.bb-15 {
			border-bottom: 1px solid rgba(65, 80, 148, 0.15);
			}
			.signature {
			padding-bottom: 10px;
			text-align: center;
			}
			@media print{
			.position_bg{
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			}
			}
		</style>
        <h4 class="stu-sub-head">@lang('admin.certificate') <a href="javascript:;" class="primary-btn small fix-gr-bg pull-right" onclick="PrintGridData();">Print </a></h4>
		
        <div class="DivBody" id="DivBody">
			<img class="position_bg" src="{{asset($certificate->file)}}" style="position: absolute; height: 100vh; width: 100% !important">
			<div class="certificate_body_inner">
				<table width="80%" align="center" class="postion_header_certificate">
					<tr>
						<td style="text-align: left;" class="tdWidth">{{ @$certificate->header_left_text}}:</td>
						<td style="text-align: center;" class="tdWidth"> @if (is_show('photo'))
							<img class="student-meta-img img-100" style="margin-left: -50px; margin-top: 50px;"
							src="{{ file_exists(@$student_detail->student_photo) ? asset($student_detail->student_photo) : asset('public/uploads/staff/demo/staff.jpg') }}"
							alt="">
						@endif</td>
						<td style="text-align: right;" class="tdWidth">@lang('common.date'): {{ @$certificate->date}}</td>
					</tr>
				</table>
				<table width="80%" align="center" >
					<tr>
						<td colspan="3" class="tdBody">{{ isset($student_detail->id) ? App\SmStudentCertificate::certificateBody($certificate->body, 2,$student_detail->id) : '' }}</td>
					</tr>
				</table>
				<table width="80%" align="center" class="postion_footer_certificate">
					<tr>
						<td style="text-align: left;" class="tdWidth">
							<div class="signature bb-15">{{ @$certificate->footer_left_text}}</div>
						</td>
						<td style="text-align: center;" class="tdWidth">
							<div class="signature bb-15">{{ @$certificate->footer_center_text}}</div>
						</td>
						<td style="text-align: right;" class="tdWidth ">
							<div class="signature bb-15">{{ @$certificate->footer_right_text}}</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
