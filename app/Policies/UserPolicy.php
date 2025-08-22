<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    protected $skip = ["read"];

    public function read(User $user){
        //return false;


    }

    public function create(User $user){

    }

    public function update(User $user, User $row){
        return false;
    }

    public function delete(User $user, User $row){
        return false;
    }
}
