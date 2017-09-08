<?php

namespace WHMCS\Module\Framework\Api;

class System extends AbstractRequest
{
    public function getPaymentMethods()
    {
        return $this->response('getPaymentMethods', [], 'paymentmethods.paymentmethod');
    }

    public function sendEmail(
        $id = null,
        $messageName = null,
        $customSubject = null,
        $customMessage,
        $customType = null,
        array $args = [])
    {
        if ($id !== null) {
            $args['id'] = $id;
        }
        if ($messageName !== null) {
            $args['messagename'] = $messageName;
        }
        if ($customType !== null) {
            $args['customtype'] = $customType;
        }
        if ($customSubject !== null) {
            $args['customsubject'] = $customSubject;
        }
        if ($customMessage !== null) {
            $args['customMessage'] = $customMessage;
        }
        if (isset($args['customvars']) && is_array($args['customvars'])) {
            $args['customvars'] = base64_encode(serialize($args['customvars']));
        }
        return $this->response('sendEmail', $args);
    }
}
