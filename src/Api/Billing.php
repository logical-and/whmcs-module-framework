<?php

namespace WHMCS\Module\Framework\Api;

class Billing extends AbstractRequest
{

    /**
     * @param $id
     * @see https://developers.whmcs.com/api-reference/getinvoice
     * @return ArrayResult
     */
    public function getInvoice($id)
    {
        return $this->response('getInvoice', ['invoiceId' => $id]);
    }

    public function getInvoices($userId = false, $status = '', array $args = [])
    {
        if ($userId) {
            $args['userId'] = $userId;
        }

        if ($status) {
            $args['status'] = $status;
        }

        return $this->response('getInvoices', $args, 'invoices.invoice');
    }

    public function updateInvoice($invoiceId, array $data = [])
    {
        return $this->response('updateInvoice', array_merge($data, ['invoiceId' => $invoiceId]));
    }

    public function addCredit($userId, $amount, $description)
    {
        return $this->response('addCredit', [
            'clientId'    => $userId,
            'amount'      => $amount,
            'description' => $description
        ]);
    }

    public function addInvoicePayment($invoiceId, $transactionId, $gateway, $amount = null, $date = null, array $args = [])
    {
        $args = array_merge([
            'invoiceId' => $invoiceId,
            'transId' => $transactionId,
            'gateway' => $gateway
        ], $args);

        if ($amount) {
            $args['amount'] = $amount;
        }

        if ($date) {
            $args['date'] = $date;
        }

        return $this->response('AddInvoicePayment', $args);
    }
}
