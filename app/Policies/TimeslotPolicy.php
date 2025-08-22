<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Timeslot;

class TimeslotPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function read(User $user){

        return true;
    }

    public function create(User $user){
        return true; //($user->id == $row->id);
    }

    public function update(User $user, Timeslot $row){
        return true; //($user->id == $row->id);
    }

    public function delete(User $user, Timeslot $row){
        return true;//($user->id == $row->id);
    }

}
