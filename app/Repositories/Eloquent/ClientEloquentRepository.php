<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Entities\Client;
use NwManager\Presenters\ClientPresenter;

/**
 * Class ClientEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ClientEloquentRepository extends AbstractEloquentRepository implements ClientRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $presenter = $this->makePresenter();

        Client::created(function($client) use($presenter) {
            $client->setPresenter($presenter);
            activity('Criado Novo Cliente', $client);
        });

        Client::updated(function($client) use($presenter) {
            $client->setPresenter($presenter);
            activity('Alterado Cliente', $client);
        });

        Client::deleted(function($client) use($presenter) {
            $client->setPresenter($presenter);
            activity('Excluído Cliente', $client);
        });
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ClientPresenter::class;
    }
}