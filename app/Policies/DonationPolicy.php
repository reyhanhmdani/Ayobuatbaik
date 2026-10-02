<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any donations (admin listing).
     */
    public function viewAny(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can view the specific donation.
     * Allowed if user is admin or the actual owner of the donation.
     */
    public function view(?User $user, Donation $donation): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->is_admin) {
            return true;
        }

        return $donation->user_id !== null && ((int) $user->id === (int) $donation->user_id);
    }

    /**
     * Determine whether the user can create donations.
     * Public / anyone can donate.
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the donation.
     * Only administrators can edit financial/status records.
     */
    public function update(User $user, Donation $donation): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can delete the donation.
     * Only administrators can delete records.
     */
    public function delete(User $user, Donation $donation): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can restore a soft-deleted donation.
     */
    public function restore(User $user, Donation $donation): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the donation.
     */
    public function forceDelete(User $user, Donation $donation): bool
    {
        return (bool) $user->is_admin;
    }
}
