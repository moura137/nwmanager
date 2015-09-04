<?php

namespace NwManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
/**
 * Class AbstractEntity
 *
 * @package NwManager\Entities;
 * @abstract
 */
abstract class AbstractEntity extends Model implements Presentable
{
    use PresentableTrait;
    
    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if (empty($value) && $value != "0") {
            $value = null;
        }
        
        parent::setAttribute($key, $value);
    }

    /**
     * Lista de Colunas
     *
     * @return array
     */
    public function columns()
    {
        if (!$this->_columns) {
            $table = $this->getTable();
            $this->_columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($table);
            $this->_columns = array_map('strtolower', $this->_columns);
        }

        return $this->_columns;
    }

    /**
     * Is Column in Table
     *
     * @param string $key
     *
     * @return bool
     */
    public function isColumn($key)
    {
        return in_array(strtolower($key), $this->columns());
    }
}