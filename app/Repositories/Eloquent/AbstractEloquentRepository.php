<?php

namespace NwManager\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
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
     * @var bool
     */
    protected $skipPresenter = true;

    /**
     * @throws RepositoryException
     */
    public function resetModel()
    {
        parent::resetModel();
        return $this;
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

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        if (!empty($column)) {
            list($column, $sort) = array_pad(explode(' ', $column), 2, '');
            if (!empty($sort)) $direction = $sort;
            $this->model = $this->model->orderBy($column, $direction);
        }
        return $this;
    }
}