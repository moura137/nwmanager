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
            $return['created_at'] = $this->formatDate($client->created_at, 'Y-m-d H:i:s');
            $return['updated_at'] = $this->formatDate($client->updated_at, 'Y-m-d H:i:s');
        }

        return $return;
    }
}