<?php

namespace PayumPostFinanceFlexBundle\Controller;

use Exception;
use Payum\Bundle\PayumBundle\Controller\NotifyController as PayumNotifyController;
use Payum\Core\Exception\InvalidArgumentException as PayumInvalidArgumentExceptionAlias;
use Payum\Core\GatewayInterface;
use Payum\Core\Request\Notify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotifyController extends PayumNotifyController
{
    public function doUnsafeAction(Request $request): Response
    {
        try {
            return parent::doUnsafeAction($request);
        } catch (PayumInvalidArgumentExceptionAlias $e) {
            $gateway = $this->buildGateway($request);
            $gateway->excute(new Notify(null));
        }

        return new Response('', 204);
    }

    protected function buildGateway(Request $request): GatewayInterface
    {
        throw new Exception(sprintf('Let\'s build a %s gateway here', $request->get('gateway')));
    }
}
