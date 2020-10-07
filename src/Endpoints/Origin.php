<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Origin
{
    use BodyAccessorTrait;
    
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Update the Origin Pull settings for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param boolean $value The value of the zone setting
     * @return bool
     */
    public function updateOriginSetting(string $zoneID, bool $value)
    {
        $return = $this->adapter->put(
            'zones/' . $zoneID . '/origin_tls_client_auth/settings',
            [
                'enabled' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }
}
