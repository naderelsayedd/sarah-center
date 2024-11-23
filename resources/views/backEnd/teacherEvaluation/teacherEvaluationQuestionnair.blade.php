@extends('backEnd.master')
@section('title')
    @lang('teacherEvaluation.teacher_questionnaire_evaluation_evaluation_list')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-0 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('teacherEvaluation.teacher_questionnaire_evaluation_evaluation_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('teacherEvaluation.dashboard')</a>
                    <a href="#">@lang('teacherEvaluation.teacher_evaluation')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
			<div class="row">
                <div class="col-lg-12">
					<div div class="row mt-20 mb-40">
						<div class="col-lg-12">
							<div class="main-title text-right">
								<a href="#" data-toggle="modal" class="primary-btn small fix-gr-bg" data-target="#add_teacher_questionnaire" title="@lang('teacherEvaluation.teacher_add_questionnaire')" data-modal-size="modal-md">
									<span class="ti-plus pr-2"></span>
									  @lang('teacherEvaluation.teacher_add_questionnaire')
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<x-table>
								<table id="table_id" class="table data-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="10%">@lang('common.sl')</th>
											<th width="90%">@lang('teacherEvaluation.teacher_questionnaire')</th>
											<th width="20%">@lang('teacherEvaluation.actions')</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</x-table>
						</div>
					</div>
				
                </div>
				<div class="modal fade admin-query" id="add_teacher_questionnaire">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('teacherEvaluation.teacher_add_questionnaire')</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
									
                                </div>

                                <div class="modal-body">
                                    <div class="container-fluid">
                                        {{ Form::open([
                                            'class' => 'form-horizontal',
                                            'files' => true,
                                            'route' => 'saveTeacherEvaluationQuestionnair',
                                            'method' => 'POST',
                                            'enctype' => 'multipart/form-data',
                                            'onsubmit' => 'return validateAddQuestionnaireForm()',
                                        ]) }}

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row mt-25">
                                                    <div class="col-lg-12" id="sibling_class_div">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                for="">@lang('teacherEvaluation.teacher_questionnaire_title') *<span></span>
                                                            </label>
                                                            <input class="primary_input_field form-control" type="text"
                                                                name="questionnaire_title" id="questionnaire_title">

                                                            <span class="modal_input_validation red_alert"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 text-center">
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                        <input class="primary-btn fix-gr-bg submit" type="submit"
                                                            value="@lang('common.save')">
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
					<div class="modal fade admin-query" id="edit_teacher_questionnaire">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('teacherEvaluation.teacher_update_questionnaire')</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
									
                                </div>

                                <div class="modal-body">
                                    <div class="container-fluid">
										{{ Form::open([
                                            'class' => 'form-horizontal',
                                            'files' => true,
                                            'route' => 'evaluationQuestionnairUpdateSubmit',
                                            'method' => 'POST',
                                            'enctype' => 'multipart/form-data',
                                            'onsubmit' => 'return validateUpdateQuestionnaireForm()',
                                        ]) }}
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row mt-25">
                                                    <div class="col-lg-12" id="sibling_class_div">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                for="">@lang('teacherEvaluation.teacher_questionnaire_title') *<span></span>
                                                            </label>
                                                            <input class="primary_input_field form-control" type="text"
                                                                name="questionnaire_title" id="questionnaire_title_update">

                                                            <span class="modal_input_validation red_alert"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 text-center">
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                        <input class="primary-btn fix-gr-bg submit" type="submit"
                                                            value="@lang('common.update')" >
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
										<input type="hidden" name="id" id="questionnairID" value="" />
									 {{ Form::close() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="modal fade" id="showDeleteQiestionnairModal" >
						<div class="modal-dialog modal-dialog-centered" id="modalSizeQuestionaier">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title" id="showDetaildModalTileQuestionnair">		@lang('teacherEvaluation.teacher_delete_questionnaire')
									</h4>
									<button type="button" class="close icons" data-dismiss="modal">×</button>
								</div>
								<div class="modal-body" id="showDetaildModalBody">
									<div class="text-center">
										<h4>@lang('teacherEvaluation.teacher_delete_questionnaire_confirm')?</h4>
									</div>
					 
									<div class="mt-40 d-flex justify-content-between">
									    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
										<a href=""  class="text-light " id="delete-questinnair-btn">
										  <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>										 
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
                
            </div>
        </div>
    </section>
	<style>
	#tbody td {
    padding-top: 5px !important;
	padding-bottom: 5px !important;
	
}
	</style>
@endsection
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')
    <script>
        $(document).ready(function() {
            $("#submissionTimeRange").attr('style', 'display: none!important');
            $("input[name='rating_submission_time']").change(function() {
                if ($(this).val() == "fixed") {
                    console.log('ok');
                    $("#submissionTimeRange").show();
                } else if ($(this).val() == "any") {
                    $("#submissionTimeRange").attr('style', 'display: none!important');
                }
            });
			
			
			// function editable quationaire
			$(document).on("click", ".edit-item" , function(e) {
				e.preventDefault();
				var Id = $(this).attr("attr-id");
				$.ajax({ 
					headers: {
					  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{route('evaluation-questionnair-update-show')}}",
					method:"POST",  
					data:{
						id:Id
					},                              
					success: function( data ) {
						$('#questionnaire_title_update').val(data);
						$('#questionnairID').val(Id);
						$('#edit_teacher_questionnaire').modal('show');
					}
                });
			});
			
			$(document).on("click", ".delete-questionnair" , function(e) {
				e.preventDefault();
				var Id = $(this).attr("attr-id");
				var ItemHref = $(this).attr("set-href");
				$('#delete-questinnair-btn').attr("href", ItemHref);
				$('#showDeleteQiestionnairModal').modal('show');
			});
        })
    </script>
	<script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": $.fn.dataTable.pipeline( {
                url: "{{route('evaluation-questionnair-list-ajax')}}",
                pages: "{{generalSetting()->ss_page_load}}" // number of pages to cache
            } ),
            columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'question', name: 'question'},
                    {data: 'action', name: 'action', orderable: false, searchable: true},
                ],
                bLengthChange: false,
                bDestroy: true,
                language: {
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: window.jsLang('quick_search'),
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>",
                    },
                },
                dom: "Bfrtip",
                buttons: [{
                    extend: "copyHtml5",
                    text: '<i class="fa fa-files-o"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: window.jsLang('copy_table'),
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                },
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: window.jsLang('export_to_excel'),
                    title: $("#logo_title").val(),
                    margin: [10, 10, 10, 0],
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: window.jsLang('export_to_csv'),
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                },
                {
                    extend: "pdfHtml5",
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: window.jsLang('export_to_pdf'),
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                    orientation: "landscape",
                    pageSize: "A4",
                    margin: [0, 0, 0, 12],
                    alignment: "center",
                    header: true,
                    customize: function(doc) {
                        doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                        doc.content.splice(1, 0, {
                            margin: [0, 0, 0, 12],
                            alignment: "center",
                            image: "data:image/png;base64," + $("#logo_img").val(),
                        });
                        doc.defaultStyle = {
                            font: 'DejaVuSans'
                        }
                    },
                },
                {
                    extend: "print",
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: window.jsLang('print'),
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ["colvisRestore"],
                },
            ],
            columnDefs: [{
                visible: false,
            }, ],
            responsive: true,
        });
    } );
    </script>
    <script>
        function deleteHomeWork(id){
            var modal = $('#deleteHomeWorkModal');
            modal.find('input[name=id]').val(id)
            modal.modal('show');
        }
    </script>
@endpush
