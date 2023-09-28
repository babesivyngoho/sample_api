<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }

        /**
         * A user who has not been assigned to an organization
         * is not authorized to do anything. 
         */
        if (!$user->organization){
            return false;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if($user->organization->political_level == "national"){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Player $player)
    {
        if($user->organization->political_level == "municipal"){
            if($user->organization->geographic->id === $player->municipality->id){
                return true;
            }
        }

        if($user->organization->political_level == "provincial"){
            if($user->organization->geographic->id === $player->municipality->province_id){
                return true;
            }
        }

        if($user->organization->political_level == "regional"){
            if($user->organization->geographic->id == $player->municipality->province->region_id){
                return true;
            }
        }

        if($user->organization->political_level == "national"){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if($user->role != "viewer"){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Player $player)
    {
        if($user->role != "viewer"){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Player $player)
    {
        if($user->role == "administrator" || $user->role == "manager"){
            return true;
        }
    }

}
