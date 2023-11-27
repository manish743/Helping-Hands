<?php

namespace App\Policies;

use App\Models\EmployeeDetail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmployeeDetail $employeeDetail): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    
        // Users can only view their own posts
        return $user->id == $employeeDetail->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeDetail $employeeDetail): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    
        // Users can only view their own posts
        return $user->org_id == $employeeDetail->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeDetail $employeeDetail): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            // if (count($employeeDetail->jobs)<1) {
                return true;
            // }
            
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmployeeDetail $employeeDetail): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeDetail $employeeDetail): bool
    {
        //
    }
}
