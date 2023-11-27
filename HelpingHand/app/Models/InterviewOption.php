<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewOption extends Model
{
    use HasFactory;
    protected $table = 'interview_options';
    public $timestamps = false;
    public $fillable =[
        'created_by',
        'interview_date',
        'interview_time',
        'candidate_id',
        'job_id',
        'job_applicant_id',
        'stage_id'
     
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by','id');
    }
    public function candidate(){
        return $this->belongsTo(Candidate::class, 'candidate_id','id');
    }
    public function job(){
        return $this->belongsTo(Job::class, 'job_id','id');
    }
    public function job_applicant(){
        return $this->belongsTo(JobApplicant::class, 'job_apllicant_id','id');
    }

}
