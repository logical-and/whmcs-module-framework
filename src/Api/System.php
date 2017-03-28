<?php

namespace WHMCS\Module\Framework\Api;

class System extends AbstractRequest
{
    public function getPaymentMethods()
    {
        return $this->response('getPaymentMethods', [], 'paymentmethods.paymentmethod');
    }
}
