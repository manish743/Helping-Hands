<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicantStage extends Model
{
    use HasFactory;
    protected $table ='job_applicant_stage';
    public $fillable=[
        'job_applicant_id',
        'job_id',
        'stage_id',
        'score',
        'is_rejected',
        'reason',
        'summary',
        'next_stage',
        'created_by',
       
    ];
    public function job_applicant(){
        return $this->belongsto(JobApplicant::class,'job_applicant_id','id');
    }
    public function created_user(){
        return $this->belongsto(User::class,'created_by','id');
    }
}
