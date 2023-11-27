<?php

namespace App\Policies;

use App\Models\EmployeeDetail;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class JobPolicy
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
    public function view(User $user, EmployeeDetail $job): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        // Users can only view their own posts
        return $user->id == $job->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->hasRole('SuperAdmin')) {
            return Response::allow();
        } 
        if ($user->hasRole('ClientAdmin')) {
            $client = $user->client;
            $job_list = Job::where('org_id', $client->id)->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count();
            if ($job_list <= $client->subscription->no_of_vacancy) {
                return Response::allow();
            }else{
                return Response::deny('Monthly Quota has been reached');
            }
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Job $job): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        // Users can only view their own posts
        return $user->org_id === $job->org_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            // if (count($job->jobs)<1) {
            return true;
            // }

        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        //
        return true;
    }
}
