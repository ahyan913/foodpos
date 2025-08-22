<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function read(User $user){

        return true;
    }

    public function create(User $user){
        return true; //($user->id == $row->id);
    }

    public function update(User $user, Role $row){
        return true; //($user->id == $row->id);
    }

    public function delete(User $user, Role $row){
        return true;//($user->id == $row->id);
    }
}
