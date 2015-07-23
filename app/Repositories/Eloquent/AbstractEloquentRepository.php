<?php

namespace NwManager\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use NwManager\Repositories\Contracts\AbstractRepository;

abstract class AbstractEloquentRepository extends BaseRepository implements AbstractRepository
{
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