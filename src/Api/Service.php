<?php

namespace WHMCS\Module\Framework\Api;

class Service extends AbstractRequest
{
    public function updateClientProduct($serviceId = null, array $args = [])
    {
        if ($serviceId) {
            $args['serviceId'] = $serviceId;
        }

        return $this->response('UpdateClientProduct', $args);
    }

    public function moduleSuspend($serviceId, $suspendReason = null, array $args = [])
    {
        $args = array_merge(['accountid' => $serviceId], $args);

        if (null !== $suspendReason) {
            $args['suspendreason'] = $suspendReason;
        }

        return $this->response('ModuleSuspend', $args);
    }

    public function moduleUnsuspend($serviceId, array $args = [])
    {
        $args = array_merge(['accountid' => $serviceId], $args);

        return $this->response('ModuleUnsuspend', $args);
    }

    public function moduleTerminate($serviceId, array $args = [])
    {
        $args = array_merge(['accountid' => $serviceId], $args);

        return $this->response('ModuleTerminate', $args);
    }
}
