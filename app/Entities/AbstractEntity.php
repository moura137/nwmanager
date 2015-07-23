<?php

namespace NwManager\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntity extends Model
{
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
}