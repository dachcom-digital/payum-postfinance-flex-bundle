# CoreShop PostFinance Flex Payum Connector
This Bundle activates the [Postfinance Flex](https://checkout.postfinance.ch) PaymentGateway in CoreShop.
It requires the [dachcom-digital/payum-postfinance-flex](https://github.com/dachcom-digital/payum-postfinance-flex) repository which will be installed automatically.

## Requirements
CoreShop >= 3.0

## Installation

```json
    "dachcom-digital/payum-postfinance-flex-bundle": "~1.1.0"
```

Add Bundle to `bundles.php`:
```php
return [
    # add to bottom
    PayumPostFinanceFlexBundle\PayumPostFinanceFlexBundle::class => ['all' => true],
];
```

#### 3. Setup
Go to CoreShop -> PaymentProvider and add a new Provider. Choose `postfinance_flex` from `type` and fill out the required fields.

## Changelog

### 1.1.0
- add integration type config

## Copyright and License
Copyright: [DACHCOM.DIGITAL](https://www.dachcom-digital.ch)
For licensing details please visit [LICENSE.md](LICENSE.md)