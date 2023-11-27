<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable=[
        'org_id',
        'project_number',
        'vacant_position',
        'job_type',
        'type_of_position',
        'department_id',
        'cim_candidate',
        'stages',
        'status',
        'project_owner',
        'hr_incharge',
    ];
    public $timestamps = true;

    public function client(){
        return $this->belongsTo(EmployeeDetail::class,'org_id','id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function questions(){
        return $this->belongsToMany(Question::class,'job_question')->withPivot('stage_id','skill_id','competency');
    }
    public function candidates(){
        return $this->belongsToMany(Candidate::class,'job_applicant')->withPivot('stage_id','summary','cover_letter','created_by','is_rejected','reason')->withTimestamps();
    }
    public function applicants(){
        return $this->hasMany(JobApplicant::class,'job_id','id');
    }
    public function job_stage_weight(){
        return$this->hasMany(JobStageWeight::class,'job_id','id');
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($job) {
            $job->questions()->detach();
            $job->job_stage_weight()->delete();
        });
    }

}
