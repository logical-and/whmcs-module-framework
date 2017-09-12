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

    public function getEmailTemplates($type = null, $lang = null, $args = [])
    {
        if (null !== $type) {
            $args['type'] = $type;
        }
        if (null !== $lang) {
            $args['language'] = $lang;
        }
        return $this->response('GetEmailTemplates', $args, 'emailtemplates.emailtemplate');
    }
}
