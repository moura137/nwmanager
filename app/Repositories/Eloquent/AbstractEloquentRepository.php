<?php

namespace NwManager\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use NwManager\Repositories\Contracts\AbstractRepository;
use Prettus\Repository\Presenter\ModelFractalPresenter;

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
     * Specify Presenter class name
     * 
     * @return string
     */
    public function presenter()
    {
        return ModelFractalPresenter::class;
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