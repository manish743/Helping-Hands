<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExperience extends Model
{
    use HasFactory;
    protected $table = 'candidate_experience';
    public $timestamps=false;
    protected $fillable = [
        'job_title',
        'job_tenure',
        'company_name',
        'responsibility',
        'achievement',
        'skills_developed',
        'candidate_id',
        'present_job',
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class,'candidate_id','id');
    }
}
