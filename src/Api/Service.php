<?php

namespace WHMCS\Module\Framework\Api;

class Service extends AbstractRequest
{
    public function updateClientProduct($serviceId = null, array $args = [])
    {
        if ($serviceId) {
            $args['serviceId'] = $serviceId;
        }

        return $this->response('UpdateClientProduct', $args);
    }
}
