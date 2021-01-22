<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'division_id',
        'group_id',
        'email',
        'password',
        'staff_no',
        'status',
        'title',
        'division_id',
        'staff_no'
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

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }
    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function fullName($id)
    {
        $user = User::findOrFail($id);
        return $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
    }

    public function getDivision($division_id)
    {

        return Division::select('*')->where('id', $division_id)->first();
    }
}
