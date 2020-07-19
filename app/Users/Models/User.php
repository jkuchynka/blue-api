<?php

namespace App\Users\Models;

use App\Users\Rules\Username;
use Base\Traits\BaseModel;
use Base\Traits\DefinesFields;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use Notifiable;
    use BaseModel;
    use DefinesFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email'
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

    /**
     * Define fields
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'id' => 'id',
            'username' => 'string|nullable|unique|'.Username::class,
            'name' => 'string|nullable|required',
            'email' => 'string|unique|required|email',
            'email_verified_at' => 'timestamp|nullable',
            'password' => 'string|hidden',
            'remember_token' => 'string|max:100',
            'timestamps' => 'timestamps'
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->orWhere('username', $value)->first();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
