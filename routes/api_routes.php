<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'teacher','as'=>'teacher.'], function(){
    /*api for listing from admin panel*/
    Route::middleware('auth:api')->get('addmission_query','api\v2\ApiController@addmissionQuery'); 
    Route::middleware('auth:api')->get('visitor_list','api\v2\ApiController@visitorList'); 
    Route::middleware('auth:api')->get('complaint_list','api\v2\ApiController@complaintList'); 
    Route::middleware('auth:api')->get('postal_receive_list','api\v2\ApiController@postalList'); 
    Route::middleware('auth:api')->get('postal_dispatch_list','api\v2\ApiController@postalDispatchList');
    Route::middleware('auth:api')->get('call_log_list','api\v2\ApiController@callLogList'); 
    Route::middleware('auth:api')->get('id_card_list','api\v2\ApiController@idCardList'); 
    Route::middleware('auth:api')->get('student_certificate_list','api\v2\ApiController@studentCertificateList');
    Route::middleware('auth:api')->get('notification_list','api\v2\ApiController@notificationList');
    Route::middleware('auth:api')->get('library_book_list','api\v2\ApiController@libraryBookList'); 
	
	/*api for listing from Teacher panel*/
	Route::middleware('auth:api')->post('students_search','api\v2\ApiController@searchByName');
    Route::middleware('auth:api')->post('students_profile','api\v2\ApiController@getProfile');
    Route::middleware('auth:api')->post('class_routine','api\v2\ApiController@getClassRoutine');
    Route::middleware('auth:api')->post('search_attendence','api\v2\ApiController@searchAttendance');
    Route::middleware('auth:api')->post('content_list','api\v2\ApiController@contentList');
    Route::middleware('auth:api')->post('content_upload','api\v2\ApiController@contentUpload');
    Route::middleware('auth:api')->get('notice_list','api\v2\ApiController@noticeList');
    Route::middleware('auth:api')->get('book_list','api\v2\ApiController@bookList');
    Route::middleware('auth:api')->post('add_homework','api\v2\ApiController@addHomework');
    Route::middleware('auth:api')->post('homework_list','api\v2\ApiController@homeworkList');

});