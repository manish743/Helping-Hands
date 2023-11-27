<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable,SoftDeletes ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'org_name',
        'first_name',
        'last_name',
        'email',
        'contact',
        'password',
        'client_admin',
        'org_id',
        'candidate_id',
        'sub_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $timestamps= true;
    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }
    public function client()
    {
        return $this->belongsTo(EmployeeDetail::class, 'org_id','id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'created_by','id');
    }
    public function interview_date(){
        return $this->hasMany(InterviewDate::class, 'created_by','id');
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the deleting event
        // static::deleting(function ($user) {
        //     $user->images()->delete();
        //     $user->roles()->detach();
        //     $user->permissions()->detach();
        // });
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address only...
        return 'samir.maharjan349@gmail.com';

        // return $this->email_address;

        // return [$this->email_address => $this->name];
 
    
    }
}
