<?php

namespace App\Policies;

use App\Models\LicenseForm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class LicenseFormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Auth::user()->hasPermissionTo('Read-LicenseForms') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LicenseForm  $licenseForm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LicenseForm $licenseForm)
    {
        return Auth::user()->hasPermissionTo('Show-LicenseForm') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Auth::user()->hasPermissionTo('Create-LicenseForm') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LicenseForm  $licenseForm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LicenseForm $licenseForm)
    {
        return Auth::user()->hasPermissionTo('Update-LicenseForm') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LicenseForm  $licenseForm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LicenseForm $licenseForm)
    {
        return Auth::user()->hasPermissionTo('Delete-LicenseForm') ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LicenseForm  $licenseForm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LicenseForm $licenseForm)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LicenseForm  $licenseForm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LicenseForm $licenseForm)
    {
        //
    }
}
