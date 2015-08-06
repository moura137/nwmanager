<?php

namespace NwManager\Transformers;

use League\Fractal\TransformerAbstract;
use \DateTime;

/**
 * Class AbstractTransformer
 *
 * @package NwManager\Transformers;
 */
abstract class AbstractTransformer extends TransformerAbstract
{
    /**
     * Format Date
     *
     * @param DateTime $date
     * @param string   $format
     *
     * @return string
     */
    protected function formatDate($date, $format)
    {
        if ($date instanceof DateTime) {
            return $date->format($format);
        }

        return null;
    }
}