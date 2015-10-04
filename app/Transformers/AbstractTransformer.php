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
     * @var boolean
     */
    protected $includeData = false;

    /**
     * Construct
     *
     * @param boolean $includeData
     */
    public function __construct($includeData = false)
    {
        $this->includeData = $includeData;
    }

    /**
     * Has Include Data
     *
     * @return boolean
     */
    public function hasIncludeData()
    {
        return $this->includeData;
    }

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