<?php

namespace PayumPostFinanceFlexBundle\Extension;

use CoreShop\Bundle\PaymentBundle\Doctrine\ORM\PaymentRepository;
use CoreShop\Component\Core\Model\OrderInterface;
use CoreShop\Component\Core\Model\PaymentProviderInterface;
use DachcomDigital\Payum\PostFinance\Flex\Request\Api\TransactionExtender;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Model\Payment;

class ConvertPaymentExtension implements ExtensionInterface
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
        $request = $context->getRequest();

        $previousActionClassName = is_object($action) ? get_class($action) : false;

        if (false === stripos($previousActionClassName, 'TransactionExtender')) {
            return;
        }

        if (!$request instanceof TransactionExtender) {
            return;
        }

        /** @var Payment $payment */
        $payment = $request->getFirstModel();

        $paymentEntity = $this->paymentRepository->createQueryBuilder('p')
            ->where('p.number = :orderNumber')
            ->setParameter('orderNumber', $payment->getNumber())
            ->getQuery()
            ->getSingleResult();

        if (!$paymentEntity instanceof \Coreshop\Component\Core\Model\Payment) {
            return;
        }

        $order = $paymentEntity->getOrder();
        if (!$order instanceof OrderInterface) {
            return;
        }

        $gatewayLanguage = 'en_EN';

        $transaction = $request->getTransaction();

        if (!empty($order->getLocaleCode())) {
            $orderLanguage = $order->getLocaleCode();
            // post finance always requires a full language ISO Code
            if (!str_contains($orderLanguage, '_')) {
                $gatewayLanguage = $orderLanguage . '_' . strtoupper($orderLanguage);
            } else {
                $gatewayLanguage = $orderLanguage;
            }
        }

        $transaction->setLanguage($gatewayLanguage);

        /** @var PaymentProviderInterface $paymentProvider */
        $paymentProvider = $paymentEntity->getPaymentProvider();
        $gatewayConfig = $paymentProvider->getGatewayConfig()->getConfig();

        $optionalParameters = [];
        if (is_array($gatewayConfig) && array_key_exists('optionalParameters', $gatewayConfig)) {
            $optionalParameters = $gatewayConfig['optionalParameters'];
        }

        if (array_key_exists('allowedPaymentMethodBrands', $optionalParameters) && !empty($optionalParameters['allowedPaymentMethodBrands'])) {
            $transaction->setAllowedPaymentMethodBrands(explode(',', $optionalParameters['allowedPaymentMethodBrands']));
        }

        if (array_key_exists('allowedPaymentMethodConfigurations', $optionalParameters) && !empty($optionalParameters['allowedPaymentMethodConfigurations'])) {
            $transaction->setAllowedPaymentMethodConfigurations(explode(',', $optionalParameters['allowedPaymentMethodConfigurations']));
        }

        $request->setTransaction($transaction);
    }
}
