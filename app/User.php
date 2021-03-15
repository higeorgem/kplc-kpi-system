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
        'staff_no',
        'password_changed_at',
        'section_id',
        'sub_section_id',
        'department_id',
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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function subsection()
    {
        // dd('here');
        return $this->belongsTo(SubSection::class, 'sub_section_id', 'id');
    }

    public function fullName($id)
    {
        $user = User::findOrFail($id);
        return ucfirst($user->first_name) . ' ' . ucfirst($user->middle_name) . ' ' . ucfirst($user->last_name);
    }

    public function getDivision($division_id)
    {

        return Division::select('*')->where('id', $division_id)->first();
    }
}
