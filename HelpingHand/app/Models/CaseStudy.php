<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;
    protected $table= 'case_studies';
    public $timestamps = true;
    protected $fillable = [
        'job_applicant_id',
        'submission_date',
        'submission_time',
        'submitted_at',
        'case_study_material',
        'case_study',
        'created_by',
    ];

    public function job_applicant(){
        return $this->belongsTo(JobApplicant::class,'job_applicant_id','id');
    }
    public function pdffile()
    {
        return $this->morphMany(PdfFile::class, 'pdffilable');
    }
}
