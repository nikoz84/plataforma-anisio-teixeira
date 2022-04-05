<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Newsletter;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view newsletter.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view in newsletter.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create newsletter.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update newsletter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function update(User $user, Newsletter $newsletter)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can delete the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function delete(User $user, Newsletter $newsletter)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can restore the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function restore(User $user, Newsletter $newsletter)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function forceDelete(User $user, Newsletter $newsletter)
    {
        return $user->role->name == 'super-admin';
    }
}
