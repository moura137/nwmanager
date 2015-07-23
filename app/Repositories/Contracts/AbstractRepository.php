<?php

namespace NwManager\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

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
}