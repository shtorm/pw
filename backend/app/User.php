<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App
 *
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $status
 * @property boolean $is_admin
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const STATUS_ACTIVE     = 1;
    const STATUS_DISABLE    = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @param $params
     * @return mixed
     * @throws \Throwable
     */
    public static function createWithAccount($params)
    {
        $user = static::create($params);

        try {
            Account::create($user->id);
        } catch (\Throwable $e) {
            $user->delete();
            throw $e;
        }

        return $user;
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
