<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    use HasFactory;
    protected $table ='job_applicant';
    public $timestamps = true;
    public $fillable =[
        'job_id',
        'candidate_id',
        'stage_id',
        'stage_complete',
        'current_complete',
        'summary',
        'created_by',
        'cover_letter',
        'is_hired',
        'is_rejected',
        'reason',
    ];

    public function job(){
        return $this->belongsTo(Job::class,'job_id','id');
    }
    public function candidate(){
        return $this->belongsTo(Candidate::class,'candidate_id','id');
    }
    public function score(){
        return $this->hasMany(JobApplicantScore::class,'job_applicant_id','id');
    }
    public function job_applicant_stage(){
        return $this->hasMany(JobApplicantStage::class,'job_applicant_id','id');
    }
    public function total_score(){
        return $this->job_applicant_stage()->sum('score')->get();
    }
    public function interview_option(){
        return $this->hasMany(InterviewOption::class, 'job_applicant_id','id');
    }
    public function interview_date(){
        return $this->hasMany(InterviewDate::class, 'job_applicant_id','id');
    }
     public function panel_interview_option(){
        return $this->interview_option()->where('stage_id',4);
     }
    public function panel_confirmed(){
        return $this->hasMany(PanelConfirmation::class,'job_applicant_id','id');
    }

    public function case_study(){
        return $this->hasOne(CaseStudy::class, 'job_applicant_id','id');
    }

    public function panels(){
        return $this->belongsToMany(PanelInterviewer::class,'panel_confirmations','job_applicant_id','panel_id')->withPivot('interview_date_id','interview_option_id','confirmed');
    }
}
