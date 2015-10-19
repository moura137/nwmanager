<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\UserRepository;
use NwManager\Entities\User;
use NwManager\Presenters\UserPresenter;

/**
 * Class UserEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class UserEloquentRepository extends AbstractEloquentRepository implements UserRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'email' => '=',
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $presenter = $this->makePresenter();

        User::created(function($user) use($presenter) {
            $user->setPresenter($presenter);
            activity('Criado Novo Usuário', $user);
        });

        User::updated(function($user) use($presenter) {
            $user->setPresenter($presenter);
            activity('Alterado Usuário', $user);
        });

        User::deleted(function($user) use($presenter) {
            $user->setPresenter($presenter);
            activity('Excluído Usuário', $user);
        });
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return UserPresenter::class;
    }
}