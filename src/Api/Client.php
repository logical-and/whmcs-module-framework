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

    /**
     * Retrieves data with `client` key for client details and `stats` key for client stat info.
     * @param int|null $clientId
     * @param int|null $email
     * @param bool|null $stats
     * @param array $args
     * @return ArrayResult
     */
    public function getClientsDetails($clientId = null, $email = null, $stats = true, array $args = [])
    {
        if (null === $clientId && null === $email) {
            throw new \InvalidArgumentException("getclientdetails api method expects email or clientid to be set.");
        }
        if (null !== $clientId) {
            $args['clientid'] = $clientId;
        }
        if (null !== $email) {
            $args['email'] = $email;
        }
        if (null !== $stats) {
            $args['stats'] = $stats;
        }
        return $this->response('GetClientsDetails', $args);
    }
}
