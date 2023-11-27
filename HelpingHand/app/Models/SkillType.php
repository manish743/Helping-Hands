<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillType extends Model
{
    use HasFactory;
    protected $table ='skill_type';
    public $fillable = [
        'name'
    ];

    public $timestamps =false;

    public function skills(){
        return $this->hasMany(Skill::class,'skill_type_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($skill_type) {
            
            $skill_type->skills()->delete();
            
        });
    }
}
