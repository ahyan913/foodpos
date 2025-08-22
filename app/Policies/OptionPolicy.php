<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Option;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function read(User $user){

        return true;
    }

    public function create(User $user){
        return true; //($user->id == $row->id);
    }

    public function update(User $user, Option $row){

        return true; //($user->id == $row->id);
    }

    public function delete(User $user, Option $row){
        return true;//($user->id == $row->id);
    }

}
