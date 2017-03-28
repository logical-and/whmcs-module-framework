<?php

namespace WHMCS\Module\Framework\Api;

class Client extends AbstractRequest
{
    public function getProducts($userId = null, $serviceId = null, $productId = null, array $args = [])
    {
        if ($userId) {
            $args['clientId'] = $userId;
        }

        if ($serviceId) {
            $args['serviceId'] = $serviceId;
        }

        if ($productId) {
            $args['productId'] = $productId;
        }

        return $this->response('getClientsProducts', $args, 'products.product');
    }
}
