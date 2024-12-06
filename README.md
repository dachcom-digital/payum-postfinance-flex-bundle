# CoreShop PostFinance Flex Payum Connector
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Software License](https://img.shields.io/badge/license-DCL-white.svg?style=flat-square&color=%23ff5c5c)](LICENSE.md)

This Bundle activates the [Postfinance Flex](https://checkout.postfinance.ch) PaymentGateway in CoreShop.
It requires the [dachcom-digital/payum-postfinance-flex](https://github.com/dachcom-digital/payum-postfinance-flex) repository which will be installed automatically.

## Requirements
CoreShop >= 3.0

## Installation

```json
    "dachcom-digital/payum-postfinance-flex-bundle": "~1.3.0"
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

***

## Changelog

### 1.3.0
- [LICENSE] Dual-License with GPL and Dachcom Commercial License (DCL) added

### 1.2.1
- Fix tax translation label

### 1.2.0
- Dependency `dachcom-digital/payum-postfinance-flex` requirement set to `^1.2`
- Unnecessary dependency `postfinancecheckout/sdk` removed
- `totalTaxes` added to line item
  - rate `title` gets translated by key: `coreshop.payum.postfinance.line_item.tax_title_[TAX_RATE]`
    - where `[TAX_RATE]` represents the tax rate (`.` gets replaced by `_`)
    - Example: If your taxrate represents `8.1`, the generated title would be `coreshop.payum.postfinance.line_item.tax_title_8_1`

### 1.1.0
- add integration type config
- add `allowedPaymentMethodConfigurations` option

### 1.0.1
- add `setAllowedPaymentMethodBrands` option

***

## License
**DACHCOM.DIGITAL AG**, Löwenhofstrasse 15, 9424 Rheineck, Schweiz  
[dachcom.com](https://www.dachcom.com), dcdi@dachcom.ch  
Copyright © 2024 DACHCOM.DIGITAL. All rights reserved.  

For licensing details please visit [LICENSE.md](LICENSE.md)  