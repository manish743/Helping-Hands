<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelInterviewer extends Model
{
    use HasFactory;
    protected $table = 'panel_interviewers';
    public $timestamps = true;
    protected $fillable =
    [
        'name',        
        'email',
        'contact',
        'org_id',
    ];
    public function job_applicants(){
        return $this->belongsToMany(JobApplicant::class,'panel_confirmations','panel_id','job_applicant_id')->withPivot('interview_date_id','interview_date_id','confirmed');
    }
}
