<?php

namespace NwManager\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use NwManager\Entities\Project;

/**
 * Class User Entity
 *
 * @package NwManager\Entities;
 */
class User extends AbstractEntity implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function owner_projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    /**
     * Members
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function member_projects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }
}
