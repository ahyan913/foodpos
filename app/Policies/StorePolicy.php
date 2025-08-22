<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function read(User $user){

        return false;
    }

    public function create(User $user){
        return false; //($user->id == $row->id);
    }

    public function update(User $user, Store $row){
        return false; //($user->id == $row->id);
    }

    public function delete(User $user, Store $row){
        return false;//($user->id == $row->id);
    }
}
