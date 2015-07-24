<?php

namespace NwManager\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use NwManager\Repositories\Contracts\AbstractRepository;

/**
 * Class AbstractEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 * @abstract
 */
abstract class AbstractEloquentRepository extends BaseRepository implements AbstractRepository
{
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string  $key
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();
        $this->applyScope();
        
        $lists = $this->model->lists($column, $key);
        
        $this->resetModel();
        return $lists;
    }
}