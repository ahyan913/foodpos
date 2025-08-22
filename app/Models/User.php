<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Constant\Gender;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = "user";

    public $timestamps = false;

    private $rolePermissions = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        "first_name",
        "last_name",
        "gender",
        "status"
    ];


    protected $isSuper = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getName(){

        return $this->first_name." ".$this->last_name;

    }

    public function getGender(){
        return Gender::getOption($this->gender);
    }

    public function isSuperAdmin(){

        if($this->isSuper)
            return true;

        foreach($this->roles as $role){
            if($role->is_super){
                $this->isSuper = true;
                return true;
            }
        }
        return false;
    }

    public function roles(){
        return $this->belongsToMany(Role::class, UserRole::TABLE, "user_id", "role_id");
    }


    public function getRolePermissions(){

        if(!$this->rolePermissions){
            foreach($this->roles as $role){
                foreach($role->permissions as $rolePermission){
                    $value = $rolePermission->policy.":".$rolePermission->action;
                    if(!in_array($value, $this->rolePermissions))
                        $this->rolePermissions[] = $value;
                }
            }
        }

        return $this->rolePermissions;
    }

    public function hasPermission($key){

        return in_array($key, $this->getRolePermissions());
    }
}
