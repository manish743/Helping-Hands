<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    use HasFactory;
    protected $table ='skill_category';

    protected $fillable =['name'];
    public $timestamps =false;

   
    public function skills(){
        return $this->belongsToMany(Skill::class);
    }
    public function questions(){
        return $this->belongsToMany(Question::class);
    }
    public function candidates(){
        return $this->belongsToMany(Candidate::class);
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($skill_category) {
            
            $skill_category->skills()->detach();
        });
    }
}
