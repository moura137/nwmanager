<?php

namespace NwManager\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Query\Expression as QueryExpression;

/**
 * Class InputCriteria
 *
 * @package Prettus\Repository\Criteria
 */
class InputCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    protected $input;

    /**
     * Construct
     *
     * @param array $input
     */
    public function __construct($input = array())
    {
        $this->input = $input;
    }

    /**
     * Get Input
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    public function getInput($key, $default = null)
    {
        if (array_key_exists($key, $this->input)) {
            return trim($this->input[$key]);
        }

        return $default;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder $query
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($query, RepositoryInterface $repository)
    {
        $input = array_filter($this->input);
        $model = $query->getModel();
        $columns = $model->columns();
        
        foreach ($input as $key => $value):
            // Parameter Grouping
            if ($value instanceof \Closure) {
                $query = $query->where($value);
                continue;
            }

            // Scope
            // eg: $query = $query->example($value);
            $methodScope = 'scope' . studly_case($key);
            if (method_exists($model, $methodScope)) {
                $methodName = camel_case($key);
                $query = $query->{$methodName}($value);
                continue;
            }

            //Using A Raw Expression
            if (is_int($key) && $value instanceof QueryExpression) {
                $query = $query->whereRaw($value);
                continue;
            }

            // Raw Expression with Bidding
            if (strpos($key, '?') !== false) {
                $query = $query->whereRaw($key, (array) $value);
                continue;
            }

            // Attributes Valids
            if (in_array(strtolower($key), $columns)) {
                // if (in_array($key, $model->getDates())) {
                //     $query = $this->whereDate($query, $key, $value);
                //     continue;
                // }

                // Using Where In With An Array
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                    continue;
                }

                // Busca Direta
                $query = $query->where($key, $value);
                continue;
            }

            // Where Search
            if ($key == config('repository.criteria.params.search', 'search')) {
                $fieldsSearchable = $repository->getFieldsSearchable();
                $query = $this->whereSearch($query, $value, $fieldsSearchable);
                continue;
            }

        endforeach;

        // Order By
        $orderBy  = $this->getInput( config('repository.criteria.params.orderBy','orderBy') , null);
        $sortedBy = $this->getInput( config('repository.criteria.params.sortedBy','sortedBy') , 'asc');
        $sortedBy = in_array(strtolower($sortedBy), ['asc', 'desc']) ? $sortedBy : 'asc';

        if ($orderBy && in_array(strtolower($orderBy), $columns)) {
            $query = $query->orderBy($orderBy, $sortedBy);
        }

        return $query;
    }

    protected function whereSearch($query, $search, array $fieldsSearchable = array())
    {
        $query = $query->where(function ($query) use ($fieldsSearchable, $search)
        {
            foreach ($fieldsSearchable as $field => $condition) {
                if (is_numeric($field)) {
                    $field = $condition;
                    $condition = "=";
                }

                $condition  = trim(strtolower($condition));

                if (!empty($search)) {
                    $value = in_array($condition, ["like", "ilike"]) ? "%{$search}%" : $search;
                    $query->orWhere($field, $condition, $value);
                }
            }
        });

        return $query;
    }
}