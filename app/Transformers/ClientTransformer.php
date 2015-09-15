<?php

namespace NwManager\Transformers;

use NwManager\Entities\Client;

/**
 * Class ClientTransformer
 *
 * @package NwManager\Transformers;
 */
class ClientTransformer extends AbstractTransformer
{
    protected $timestamps = true;

    /**
     * Construct
     *
     * @param boolean $timestamps
     */
    public function __construct($timestamps = true)
    {
        $this->timestamps = $timestamps;
    }

    /**
     * Transform the Client entity
     *
     * @param Client $client
     *
     * @return array
     */
    public function transform(Client $client)
    {
        $return = [
            'id'            => (int) $client->id,
            'name'          => $client->name,
            'responsible'   => $client->responsible,
            'email'         => $client->email,
            'phone'         => $client->phone,
            'address'       => $client->address,
            'obs'           => $client->obs,
        ];

        if (!$this->includeData) {
            $data['created_at'] = $this->formatDate($client->created_at, 'Y-m-d H:i:s');
            $data['updated_at'] = $this->formatDate($client->updated_at, 'Y-m-d H:i:s');
        }

        return $return;
    }
}