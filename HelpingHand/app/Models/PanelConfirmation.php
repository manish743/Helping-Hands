<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelConfirmation extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'panel_confirmations';
    public $timestamps = false;
    protected $fillable =
    [
        'job_applicant_id',
        'panel_id',
        'interview_date_id',
        'interview_option_id',
        'confirmed',
    ];
    public function job_applicant(){
        return $this->belongsTo(JobApplicant::class,'job_applicant_id','id');
    }
    public function panel(){
        return $this->belongsTo(PanelInterviewer::class,'panel_id','id');
    }

    public function interview_date(){
       return $this->belongsTo(InterviewDate::class,'interview_date_id','id');
    }
    public function interview_option(){
       return $this->belongsTo(InterviewOption::class,'interview_option_id','id');
    }
}
