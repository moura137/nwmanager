<?php

namespace NwManager\Serializers;

use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\ResourceInterface;

/**
 * Class DefaultSerializer
 *
 * @package NwManager\Serializers
 */
class DefaultSerializer extends DataArraySerializer
{
    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $resourceKey ? $data : array('data' => $data);
    }
}
