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

    public function getCredits($clientId, array $args = [])
    {
        $args = array_merge(['clientid' => $clientId], $args);

        return $this->response('GetCredits', $args, 'credits.credit.0');
    }

    public function addInTransaction(
        $userId,
        $paymentMethod,
        $sum,
        $description = null,
        $invoiceId = null,
        array $args = []
    ) {
        $args = array_merge(['amountin' => $sum], $args);

        return $this->addTransaction($userId, $paymentMethod, $description,
            $invoiceId, $args);
    }

    public function addOutTransaction(
        $userId,
        $paymentMethod,
        $sum,
        $description = null,
        $invoiceId = null,
        array $args = []
    ) {
        $args = array_merge(['amountout' => $sum], $args);

        return $this->addTransaction($userId, $paymentMethod, $description,
            $invoiceId, $args);
    }

    public function addTransaction(
        $userId,
        $paymentMethod,
        $description = null,
        $invoiceId = null,
        array $args = []
    ) {
        $args = array_merge([
            'paymentmethod' => $paymentMethod,
            'userid'        => $userId
        ], $args);
        if (null !== $description) {
            $args['description'] = $description;
        }
        if (null !== $invoiceId) {
            $args['invoiceid'] = $invoiceId;
        }
        if (isset($args['amountout']) && isset($args['amountin'])) {
            throw new \InvalidArgumentException('Both amountin and amountout can not be set.');
        }
        if (!isset($args['userid']) && !isset($args['invoiceid'])) {
            throw new \InvalidArgumentException('invoiceid or userid must be set.');
        }
        if (!isset($args['invoiceid']) && !isset($args['description'])) {
            throw new \InvalidArgumentException('invoiceid or description must be set.');
        }
        return $this->response('AddTransaction', $args);
    }
}
