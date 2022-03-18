<?php

namespace App\Policies;

use App\User;
use App\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any sessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can view the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function view(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can create sessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->belongsToRole->level <= 3 ? true : false;
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function delete(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can restore the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function restore(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function forceDelete(User $user, Session $session)
    {
        //
    }
}
