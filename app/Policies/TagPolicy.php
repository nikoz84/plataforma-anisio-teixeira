<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin'
            || $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin'
            || $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin'
            || $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin'
            || $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function restore(User $user, Tag $tag)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function forceDelete(User $user, Tag $tag)
    {
        return $user->role->name == 'super-admin';
    }
}
