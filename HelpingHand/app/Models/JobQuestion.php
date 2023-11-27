<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    use HasFactory;
    protected $table = 'job_question';

    protected $fillable = [
        'job_id',
        'question_id',
        'skill_id',
        'stage_id',
        'competency',
    ];
    public $timestamps= false;
 
    public function skill(){
        return $this->belongsTo(Skill::class,'skill_id', 'id');
    }
    public function question(){
        return $this->belongsTo(Question::class,'question_id', 'id');
    }
    public function job(){
        return $this->belongsTo(Job::class,'job_id', 'id');
    }
}
