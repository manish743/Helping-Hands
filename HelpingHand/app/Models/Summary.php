<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    public $table = 'summaries';
    protected $fillable=
    [
        'description',
        'candidate_id',
        'category',
        'created_by',
    ];
    public $timestamps = true;
    public function candidate(){
        return $this->belongsTo(Candidate::class,'candidate_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
