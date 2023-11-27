<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Candidate extends Model
{
    use HasFactory;
    protected $table = 'candidates';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'current_salary',
        'expected_salary',
        'job_type',
        'speciality',
        'interest',
        'created_by',
        'summary',
        'is_screened',
        'category',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }
    public function pdffile()
    {
        return $this->morphMany(PdfFile::class, 'pdffilable');
    }
    // public function images()
    // {
    //     return $this->morphMany(Image::class, 'imagable')->onDelete(function ($image) {
    //         $image->delete();
    //     });
    // }

    // public function pdffile()
    // {
    //     return $this->morphMany(PdfFile::class, 'pdffilable')->onDelete(function ($pdfFile) {
    //         $pdfFile->delete();
    //     });
    // }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
    public function skill_category()
    {
        return $this->belongsToMany(SkillCategory::class);
    }
    public function user()
    {
        return $this->hasOne(User::class, 'candidate_id', 'id');
    }
    public function experience()
    {
        return $this->hasMany(CandidateExperience::class, 'candidate_id', 'id');
    }

    public function jobs(){
        return $this->belongsToMany(Job::class,'job_applicant')->withPivot('stage_id','summary','cover_letter','created_by','is_rejected','reason')->withTimestamps();
    }

   
    public function interview_option(){
        return $this->hasMany(InterviewOption::class, 'candidate_id','id');
    }
    public function interview_date(){
        return $this->hasMany(InterviewDate::class, 'candidate_id','id');
    }
    public function summary(){
        return $this->hasMany(Summary::class, 'candidate_id','id')->orderBy('created_at', 'desc');
    }
    // public function summary(){
    //     return $this->summary_list()->orderBy('created_at','desc')->first();
    // }
  



    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($candidate) {
            Log::info('Candidate deleting event triggered');
            Log::info('pdf count :' . count($candidate->pdffile));
            Log::info('image count :' . count($candidate->images));
            // $candidate->images()->delete();
            if (count($candidate->images) > 0) {
                foreach ($candidate->images as $value) {
                    Log::info('image deleting loop triggered');
                    $value->delete();
                }
            }

            // $candidate->pdffile()->delete();
            if (count($candidate->pdffile) > 0) {
                foreach ($candidate->pdffile as $pdf) {
                    Log::info('pdf deleting loop triggered');
                    $pdf->delete();
                }
            }
            $candidate->user()->delete();
            $candidate->skills()->detach();
            $candidate->skill_category()->detach();
        });
    }
}
