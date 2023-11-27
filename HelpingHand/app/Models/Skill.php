<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $table ='skills';

    public $fillable =['name', 'competency'];
    public $timestamps =false;

 
    public function skill_category(){
        return $this->belongsToMany(SkillCategory::class);
    }
    public function questions(){
        return $this->belongsToMany(Question::class);
    }
    public function candidates(){
        return $this->belongsToMany(Candidate::class);
    }
    public function job_questions(){
        return $this->hasMany(JobQuestion::class,'skill_id','id');
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($skill) {
            
            $skill->skill_category()->detach();
            $skill->questions()->detach();
            $skill->job_questions()->delete();
        });
    }
}
