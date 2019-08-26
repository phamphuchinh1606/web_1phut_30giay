<?php

namespace App;

use App\Models\UserBranch;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getPrimaryKeyName()
    {
        return with(new static)->getKeyName();
    }

    public static function getFillableColumns()
    {
        return with(new static)->getFillable();
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function user_branches(){
        return $this->hasMany(UserBranch::class,'user_id');
    }

    public function checkAssetBranch($branchId){
        foreach ($this->user_branches as $userBranch){
            if($branchId == $userBranch->branch_id){
                return true;
            }
        }
        return false;
    }

    public function deleteRelation(){
        $this->user_branches()->delete();
    }
}
