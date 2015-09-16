<?php

namespace NwManager\Entities;

/**
 * Class Project Entity
 *
 * @package NwManager\Entities;
 */
class Project extends AbstractEntity
{
    const STATUS_ATIVO = '1';
    const STATUS_ENCERRADO = '2';
    const STATUS_PAUSADO = '3';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'owner_id',
		'client_id',
		'name',
		'description',
		'progress',
		'status',
		'due_date',
	];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['due_date'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'progress' => 'integer',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'progress' => 0,
    ];

    /**
     * Is Ativo
     *
     * @return boolean
     */
    public function isAtivo()
    {
        return (bool) ($this->status == self::STATUS_ATIVO);
    }

    /**
     * Is Owner
     *
     * @param int $userId
     *
     * @return boolean
     */
    public function isOwner($userId)
    {
        return (bool) ($this->owner_id == $userId);
    }

    /**
     * Has Member
     *
     * @param int $userId
     *
     * @return boolean
     */
    public function hasMember($userId)
    {
        return (bool) ($this->members()->where('user_id', $userId)->count());
    }

    /**
     * Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function owner()
	{
		return $this->belongsTo(User::class);
	}

	/**
     * Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

    /**
     * Notes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(ProjectNote::class);
    }

    /**
     * Files
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    /**
     * Tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    /**
     * Members
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
