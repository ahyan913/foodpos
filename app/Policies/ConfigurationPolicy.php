<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Configuration;

class ConfigurationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function read(User $user){
        return false;
    }

    public function update(User $user, Configuration $row){
        return false; //($user->id == $row->id);
    }

}
