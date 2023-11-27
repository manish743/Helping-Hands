<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $table = 'specialization';
    public $fillable=[
        'name'
    ];
    public $timestamps= false;

    public function org_type(){
        return $this->belongsToMany(OrganizationType::class)->using(OrgtypeSpecialization::class);
    }
    public function client(){
        return $this->belongsToMany(EmployeeDetail::class);
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($client) {
            
            $client->org_type()->detach();
        });
    }
}
