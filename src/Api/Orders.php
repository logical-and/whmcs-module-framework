<?php

namespace WHMCS\Module\Blazing\DashboardProxy\Api;

class Orders extends AbstractRequest
{

    /**
     * @param $id
     * @return ArrayResult
     * @see https://developers.whmcs.com/api-reference/getorders
     */
    public function getOrder($id)
    {
        return $this->response('getOrders', ['id' => $id], 'orders.order.0');
    }

    public function getOrders($userId = false, $status = '', array $args = [])
    {
        if ($userId) {
            $args['userId'] = $userId;
        }

        if ($status) {
            $args['status'] = $status;
        }

        return $this->response('getOrders', $args, 'orders.order');
    }
}
