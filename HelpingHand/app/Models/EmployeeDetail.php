<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;
    protected $table= 'employee_details';
    public $timestamps = true;
    protected $fillable = [
        'org_name',
        'org_email',
        'owner_full_name',
        'owner_email',
        'contact',
        'no_vacaancy',
        'subscription_package_id',
        'org_type_id',
        'org_description',
        'expires_at'
    ];
    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionPackage::class,'subscription_package_id','id');
    }
    public function org_type()
    {
        return $this->belongsTo(OrganizationType::class,'org_type_id','id');
    }
    public function user()
    {
        return $this->hasMany(User::class,'org_id','id');
    }
    public function departments()
    {
        return $this->hasMany(Department::class,'org_id','id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class,'org_id','id');
    }
    public function active_jobs()
    {
        return $this->jobs()->where('cim_candidate', 1)->where('status',1);
    }

    public function specialization(){
        return $this->belongsToMany(Specialization::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        static::deleting(function ($client) {
            
            $client->images()->delete();
            $client->user()->delete();
            $client->specialization()->detach();
        });
    }
}
