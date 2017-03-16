<?php

namespace WHMCS\Module\Blazing\DashboardProxy\Api;

class System extends AbstractRequest
{
    public function getPaymentMethods()
    {
        return $this->response('getPaymentMethods', [], 'paymentmethods.paymentmethod');
    }
}
