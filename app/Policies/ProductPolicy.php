<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Product;

class ProductPolicy extends BasePolicy
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

    public function update(User $user, Product $row){
        return false; //($user->id == $row->id);
    }

    public function delete(User $user, Product $row){
        return false;//($user->id == $row->id);
    }
}
