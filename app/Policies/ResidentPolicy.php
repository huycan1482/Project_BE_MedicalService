<?php

namespace App\Policies;

use App\User;
use App\Resident;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResidentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any residents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can view the resident.
     *
     * @param  \App\User  $user
     * @param  \App\Resident  $resident
     * @return mixed
     */
    public function view(User $user, Resident $resident)
    {
        //
    }

    /**
     * Determine whether the user can create residents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can update the resident.
     *
     * @param  \App\User  $user
     * @param  \App\Resident  $resident
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can delete the resident.
     *
     * @param  \App\User  $user
     * @param  \App\Resident  $resident
     * @return mixed
     */
    public function delete(User $user, Resident $resident)
    {
        //
    }

    /**
     * Determine whether the user can restore the resident.
     *
     * @param  \App\User  $user
     * @param  \App\Resident  $resident
     * @return mixed
     */
    public function restore(User $user, Resident $resident)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the resident.
     *
     * @param  \App\User  $user
     * @param  \App\Resident  $resident
     * @return mixed
     */
    public function forceDelete(User $user, Resident $resident)
    {
        //
    }
}
