<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicantScore extends Model
{
    use HasFactory;
    protected $table ='job_applicant_score';
    public $timestamps = false;
    public $fillable =
    [
        'job_applicant_id',
        'stage_id',
        'competency',
        'competency_score',
        'stage_score',
        'panel_id',
    ];

    public function job_applicant(){
        return $this->belongsto(JobApplicant::class,'job_applicant_id','id');
    }
    
}
