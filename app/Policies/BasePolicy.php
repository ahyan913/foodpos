<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected $skip = [];

    public function before(User $user, string $ability){

        if($user->isSuperAdmin()){
            return true;

        }elseif(!in_array($ability, $this->skip)){

            return $user->hasPermission(get_class($this).":".$ability);

        }
    }



}
