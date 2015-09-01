<?php

namespace NwManager\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AbstractRepository
 *
 * @package NwManager\Repositories\Contracts;
 */
interface AbstractRepository extends RepositoryInterface
{
    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string  $key
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null);

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');
}