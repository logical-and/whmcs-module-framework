<?php

namespace WHMCS\Module\Framework\Api;

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

    public function getProduct($productId, $groupId = null, $module = null)
    {
        $args = [
            'pid' => $productId
        ];

        if ($groupId) {
            $args['gid'] = $groupId;
        }

        if ($module) {
            $args['module'] = $module;
        }

        return $this->response('getProducts', $args, 'products.product.0');
    }

    public function getProducts($productIds = null, $groupId = null, $module = null)
    {
        $args = [];

        if ($productIds) {
            $args['id'] = $productIds;
        }

        if ($groupId) {
            $args['gid'] = $groupId;
        }

        if ($module) {
            $args['module'] = $module;
        }

        return $this->response('getProducts', $args, 'products.product.0');
    }
}
