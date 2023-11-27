<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStageWeight extends Model
{
    use HasFactory;
    protected $table ='job_stage_weight';
    public $timestamps = false;
    protected $fillable=[
        'job_id',
        'stage_id',
        'competency',
        'competency_weight',
        'stage_weight',
    ];
    public function job(){
        return$this->belongsTo(Job::class,'job_id','id');
    }
}
