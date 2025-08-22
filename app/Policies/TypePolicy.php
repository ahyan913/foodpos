<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Type;

class TypePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function read(User $user){

        return false;
    }

    public function create(User $user){
        return false; //($user->id == $row->id);
    }

    public function update(User $user, ProductType $row){
        return false; //($user->id == $row->id);
    }

    public function delete(User $user, ProductType $row){
        return false;//($user->id == $row->id);
    }

}
