<?php

namespace PayumPostFinanceFlexBundle\Extension;

use CoreShop\Bundle\PaymentBundle\Doctrine\ORM\PaymentRepository;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Model\Payment;
use Payum\Core\Request\Convert;

class ConvertPaymentPageExtension implements ExtensionInterface
{

    public function __construct(
        protected PaymentRepository $paymentRepository
    ) {

    }

    public function onPreExecute(Context $context)
    {

    }

    public function onExecute(Context $context)
    {

    }

    public function onPostExecute(Context $context)
    {
        $action = $context->getAction();

        $previousActionClassName = is_object($action) ? get_class($action) : false;
        if (false === stripos($previousActionClassName, 'ConvertPaymentPageAction')) {
            return;
        }

        /** @var Convert $request */
        $request = $context->getRequest();
        if (false === $request instanceof Convert) {
            return;
        }

        /** @var Payment $payment */
        $payment = $request->getSource();

        $paymentEntity = $this->paymentRepository->createQueryBuilder('p')
            ->where('p.number = :orderNumber')
            ->setParameter('orderNumber', $payment->getNumber())
            ->getQuery()
            ->getSingleResult();

        if (!$paymentEntity instanceof \Coreshop\Component\Core\Model\Payment) {
            return;
        }
        $order = $paymentEntity->getOrder();
        $gatewayLanguage = 'en_EN';

        if (!empty($order->getLocaleCode())) {
            $orderLanguage = $order->getLocaleCode();
            // post finance always requires a full language ISO Code
            if (!str_contains($orderLanguage, '_')) {
                $gatewayLanguage = $orderLanguage . '_' . strtoupper($orderLanguage);
            } else {
                $gatewayLanguage = $orderLanguage;
            }
        }

        $result = ArrayObject::ensureArrayObject($request->getResult() ?? []);

        $result['LANGUAGE'] = $gatewayLanguage;

        $request->setResult($result->toUnsafeArray());
    }
}
