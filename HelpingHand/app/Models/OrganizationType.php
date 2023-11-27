<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    use HasFactory;
    protected $table = "organization_types";
    public $timestamps = false;
    protected $fillable = [
        'org_type',
        'specialization',
        'is_active'
    ];

    public function specialization(){
        return $this->belongsToMany(Specialization::class)->using(OrgtypeSpecialization::class);
    }

    public function client(){
        return $this->hasMany(EmployeeDetail::class, 'org_type_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($client) {
            
            $client->specialization()->detach();
        });
    }
}
