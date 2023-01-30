<?php

namespace PayumPostFinanceFlexBundle\Helper;

use CoreShop\Component\Customer\Model\Company;
use CoreShop\Component\Order\Model\OrderInterface;
use PostFinanceCheckout\Sdk\Model\AddressCreate;
use PostFinanceCheckout\Sdk\Model\LineItemCreate;
use PostFinanceCheckout\Sdk\Model\LineItemType;

class FlexObjectsHelper
{
    const KEY_POSTFINANCE_OBJECTS = 'POSTFINANCE_OBJECTS';
    const KEY_POSTFINANCE_OBJECTS_LINE_ITEMS = 'LINE_ITEMS';
    const KEY_POSTFINANCE_OBJECT_SHIPPING_ADDRESS = 'SHIPPING_ADDRESS';
    const KEY_POSTFINANCE_BILLING_ADDRESS = 'BILLING_ADDRESS';
    const KEY_CURRENCY_CODE = 'CURRENCY_CODE';

    public function collectOrderData(OrderInterface $order): array
    {
        $items = $order->getItems();
        $orderBillingAddress = $order->getInvoiceAddress();
        $orderShippingAddress = $order->getShippingAddress();

        $lineItems = [];

        foreach ($items as $orderItem) {
            $lineItem = [
                'type' => LineItemType::PRODUCT,
                'name' => $orderItem->getName(),
                'uniqueId' => $orderItem->getId(),
                'quantity' => $orderItem->getQuantity(),
                'amountIncludingTax' => $orderItem->getTotal() / 100,
                'sku' => $orderItem->getFullPath()];

            $lineItems[] = $lineItem;
        }

        if (!empty($lineItems)) {
            $shippingItem = [
                'type' => LineItemType::SHIPPING,
                'amountIncludingTax' => $order->getConvertedShipping() / 100,
                'uniqueId' => uniqid('shipping_', true),
                'name' => 'shipping',
                'quantity' => 1
            ];
            $lineItems[] = $shippingItem;
        }

        $billingAddress = [
            'city' => $orderBillingAddress->getCity(),
            'country' => $orderBillingAddress->getCountry()->getIsoCode(),
            'emailAddress' => $order->getCustomer()->getEmail(),
            'familyName' => $order->getCustomer()->getLastname(),
            'givenName' => $order->getCustomer()->getFirstname(),
            'postCode' => $orderBillingAddress->getPostcode(),
            'phoneNumber' => $orderBillingAddress->getPhoneNumber(),
            'salutation' => $orderBillingAddress->getSalutation()
        ];

        if ($order->getCustomer()->getCompany() instanceof Company) {
            $billingAddress['organizationName'] = $order->getCustomer()->getCompany()->getName();
        }

        $shippingAddress = [
            'city' => $orderShippingAddress->getCity(),
            'country' => $orderShippingAddress->getCountry()->getIsoCode(),
            'emailAddress' => $order->getCustomer()->getEmail(),
            'familyName' => $order->getCustomer()->getLastname(),
            'givenName' => $order->getCustomer()->getFirstname(),
            'postCode' => $orderShippingAddress->getPostcode(),
            'phoneNumber' => $orderShippingAddress->getPhoneNumber(),
            'salutation' => $orderShippingAddress->getSalutation()
        ];

        if ($order->getCustomer()->getCompany() instanceof Company) {
            $shippingAddress['organizationName'] = $order->getCustomer()->getCompany()->getName();
        }

        return [
            self::KEY_POSTFINANCE_OBJECTS_LINE_ITEMS => $lineItems,
            self::KEY_POSTFINANCE_OBJECT_SHIPPING_ADDRESS => $shippingAddress,
            self::KEY_POSTFINANCE_BILLING_ADDRESS => $billingAddress
        ];

    }

    public function setupFlexObjects(array $data): array
    {
        $result = [];
        $lineItems = [];

        foreach ($data[self::KEY_POSTFINANCE_OBJECTS_LINE_ITEMS] as $orderItem) {
            $lineItem = new LineItemCreate();
            $lineItem->setType($orderItem['type']);
            $lineItem->setName($orderItem['name']);
            $lineItem->setUniqueId($orderItem['uniqueId']);
            $lineItem->setQuantity($orderItem['quantity']);
            $lineItem->setAmountIncludingTax($orderItem['amountIncludingTax']);
            $lineItem->setSku($orderItem['sku']);

            $lineItems[] = $lineItem;
        }

        $result[self::KEY_POSTFINANCE_OBJECTS_LINE_ITEMS] = $lineItems;

        foreach ([
                     self::KEY_POSTFINANCE_OBJECT_SHIPPING_ADDRESS,
                     self::KEY_POSTFINANCE_BILLING_ADDRESS
                 ] as $addressType => $addressData) {
            $addressObject = new AddressCreate();
            $addressObject->setCity($data[$addressType]['city']);
            $addressObject->setCountry($data[$addressType['country']]);
            $addressObject->setEmailAddress($data[$addressType]['emailAddress']);
            $addressObject->setFamilyName($data[$addressType]['familyName']);
            $addressObject->setGivenName($data[$addressType]['givenName']);
            $addressObject->setPostCode($data[$addressType]['postCode']);
            if (array_key_exists('organizationName', $data)) {
                $addressObject->setOrganizationName($data[$addressType]['organizationName']);
            }
            $addressObject->setPhoneNumber($data[$addressType]['phoneNumber']);
            $addressObject->setSalutation($data[$addressType]['salutation']);

            $result[$addressType] = $addressObject;
        }

        return $result;
    }
}
