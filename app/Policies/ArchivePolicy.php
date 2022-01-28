<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchivePolicy
{
    use HandlesAuthorization;


    /**
     * Run a check before all policy for...
     *
     * @param \app\Models\User $user
     * @return mixed
     */
    public function before(User $user)
    {
        // something
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function view(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function update(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function delete(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function restore(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function forceDelete(User $user, Archive $archive)
    {
        //
    }

    /**
     * Determine whether the user can process the archive into a gallery.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Archive  $archive
     * @return mixed
     */
    public function process(User $user, Archive $archive)
    {
        return $user->id === $archive->user_id;
    }
}
