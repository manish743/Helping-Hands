<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;
    protected $table = "subscription_packages";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'package_type',
        'subscription_duration',
        'no_of_users',
        'no_of_vacancy',
        'can_generate_link',
        'can_ask_cim',
        'is_active',
    ];
    public function client()
    {
        return $this->hasMany(EmployeeDetail::class,'subscription_package_id','id');
    }
    public function deleteWithReassign($newCategoryId)
    {
        // Find all items in the category being deleted and update their category_id
        EmployeeDetail::where('subscription_package_id', $this->id)->update(['subscription_package_id' => $newCategoryId]);

        // Delete the category
        $this->delete();
    }
}
