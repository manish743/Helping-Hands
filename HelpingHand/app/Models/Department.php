<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    public $table= 'departments';
    protected $fillable=[
        'name',
        'org_id',
    ];
    public $timestamps = true;
    public function client(){
        return $this->belongsTo(EmployeeDetail::class,'org_id','id');
    }
    public function jobs(){
        return $this->hasMany(Job::class,'department_id','id');
    }
}
