<?php

namespace App\Policies;

use App\User;
use App\InjectionObject;
use Illuminate\Auth\Access\HandlesAuthorization;

class InjectionObjectPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any injection objects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can view the injection object.
     *
     * @param  \App\User  $user
     * @param  \App\InjectionObject  $injectionObject
     * @return mixed
     */
    public function view(User $user, InjectionObject $injectionObject)
    {
        //
    }

    /**
     * Determine whether the user can create injection objects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the injection object.
     *
     * @param  \App\User  $user
     * @param  \App\InjectionObject  $injectionObject
     * @return mixed
     */
    public function update(User $user, InjectionObject $injectionObject)
    {
        //
    }

    /**
     * Determine whether the user can delete the injection object.
     *
     * @param  \App\User  $user
     * @param  \App\InjectionObject  $injectionObject
     * @return mixed
     */
    public function delete(User $user, InjectionObject $injectionObject)
    {
        //
    }

    /**
     * Determine whether the user can restore the injection object.
     *
     * @param  \App\User  $user
     * @param  \App\InjectionObject  $injectionObject
     * @return mixed
     */
    public function restore(User $user, InjectionObject $injectionObject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the injection object.
     *
     * @param  \App\User  $user
     * @param  \App\InjectionObject  $injectionObject
     * @return mixed
     */
    public function forceDelete(User $user, InjectionObject $injectionObject)
    {
        //
    }
}
