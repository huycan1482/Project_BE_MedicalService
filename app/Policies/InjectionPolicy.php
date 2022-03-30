<?php

namespace App\Policies;

use App\User;
use App\Injection;
use Illuminate\Auth\Access\HandlesAuthorization;

class InjectionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any injections.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can view the injection.
     *
     * @param  \App\User  $user
     * @param  \App\Injection  $injection
     * @return mixed
     */
    public function view(User $user, Injection $injection)
    {
        //
    }

    /**
     * Determine whether the user can create injections.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can update the injection.
     *
     * @param  \App\User  $user
     * @param  \App\Injection  $injection
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can delete the injection.
     *
     * @param  \App\User  $user
     * @param  \App\Injection  $injection
     * @return mixed
     */
    public function delete(User $user, Injection $injection)
    {
        //
    }

    /**
     * Determine whether the user can restore the injection.
     *
     * @param  \App\User  $user
     * @param  \App\Injection  $injection
     * @return mixed
     */
    public function restore(User $user, Injection $injection)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the injection.
     *
     * @param  \App\User  $user
     * @param  \App\Injection  $injection
     * @return mixed
     */
    public function forceDelete(User $user, Injection $injection)
    {
        //
    }
}
