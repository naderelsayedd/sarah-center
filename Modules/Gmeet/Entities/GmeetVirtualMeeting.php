<?php

namespace Modules\Gmeet\Entities;

use App\User;
use App\SmClass;
use App\SmSection;
use Carbon\Carbon;
use App\SmGeneralSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GmeetVirtualMeeting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected static function newFactory()
    {
        return \Modules\Gmeet\Database\factories\GmeetVirtualMeetingFactory::new();
    }
    public function participates()
    {
        return $this->belongsToMany(User::class, 'gmeet_virtual_meeting_users','meeting_id','user_id');
    }

    public function class()
    {
        return $this->hasOne(SmClass::class,'id','class_id')->withDefault();
    }

    public function section()
    {
        return $this->hasOne(SmSection::class,'id','section_id')->withDefault();
    }

    public function getParticipatesNameAttribute()
    {
        return implode(', ', $this->participates->pluck('full_name')->toArray());
    }

    public function getMeetingDateTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting.' '.$this->time_of_meeting)->format('m-d-Y h:i A');
    }

    public function getCurrentStatusAttribute()
    {  
        $GSetting = SmGeneralSettings::where('school_id', auth()->user()->school_id)->first();
         date_default_timezone_set($GSetting->timeZone->time_zone);
        $now = Carbon::now()->setTimezone($GSetting->timeZone->time_zone);
        if($this->time_before_start==null){
            $meeting_start=10;
        }else{
            $meeting_start=$this->time_before_start;
        }
        if($this->is_recurring == 1){
            if($now->between(Carbon::parse($this->start_time)->addMinute(-$meeting_start)->format('Y-m-d H:i:s'), Carbon::parse($this->recurring_end_date)->endOfDay()->format('Y-m-d H:i:s'))){
                return 'started';
            }
            if(!$now->gt(Carbon::parse($this->recurring_end_date)->addMinute(-$meeting_start))){
                return 'waiting';
            }
            return 'closed';
        }else{
            if($now->between(Carbon::parse($this->start_time)->addMinute(-$meeting_start)->format('Y-m-d H:i:s'), Carbon::parse($this->end_time)->format('Y-m-d H:i:s'))){
                return 'started';
            }

            if(!$now->gt(Carbon::parse($this->end_time)->addMinute(-$meeting_start))){
                return 'waiting';
            }
            return 'closed';
        }
    }

    public function getMeetingEndTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting.' '.$this->time_of_meeting)->addMinute($this->meeting_duration);
    }

    public function getUrlAttribute()
    {
        if(auth()->user()->id == $this->created_by || auth()->user()->role_id == 1){
           return 'https://zoom.us/wc/'.$this->meeting_id.'/start';
        }else{
           return 'https://zoom.us/wc/'.$this->meeting_id.'/join';
        }
    }
}
