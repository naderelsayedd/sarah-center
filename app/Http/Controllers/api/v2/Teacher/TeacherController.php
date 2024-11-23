<?php

namespace App\Http\Controllers\api\v2\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\TeachersListResource;
use App\Models\StudentRecord;
use App\Models\TeacherEvaluationSetting;
use App\SmAssignSubject;
use App\SmNotification;
use App\SmStudent;
use App\User;
use App\SmBook;
use App\SmStaff;
use App\SmClass;
use App\SmSection;
use App\SmVisitor;
use App\SmWeekend;
use App\SmHomework;
use App\SmClassRoom;
use App\SmClassTime;
use App\SmComplaint;
use App\ApiBaseMethod;
use App\SmNoticeBoard;
use App\SmAcademicYear;
use App\SmPhoneCallLog;
use App\SmClassTeacher;
use App\SmPostalReceive;
use App\SmStudentIdCard;
use App\SmPostalDispatch;
use App\SmAdmissionQuery;
use App\SmAssignClassTeacher;
use App\SmStudentCertificate;
use App\SmClassRoutineUpdate;
use App\SmTeacherUploadContent;
use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StudyMeterialCreatedNotification;
use App\Http\Controllers\Admin\StudentInfo\SmStudentReportController;
use Modules\RolePermission\Entities\InfixRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotificationSend;

class TeacherController extends Controller
{
    use NotificationSend;
   



    
    
    

}
