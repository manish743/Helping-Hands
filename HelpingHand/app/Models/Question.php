<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table ='questions';
    protected$fillable =[
        'question',
        'created_by',
        'competency',
    ];
    public $timestamps = true;

    public function skills(){
        return $this->belongsToMany(Skill::class);
    }
    public function skill_category(){
        return $this->belongsToMany(SkillCategory::class);
    }
    public function job(){
        return $this->belongsToMany(Job::class)->withPivot('stage_id','skill_id','competency');
    }
    // public function user(){
    //     return $this->belongsTo(User::class,'created_by', 'id');
    // }
    public function client(){
        return $this->belongsTo(EmployeeDetail::class,'created_by', 'id');
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($skill) {
            
            $skill->skills()->detach();
            $skill->job()->detach();
        });
        
    }
}
