# CoreShop PostFinance Flex Payum Connector
This Bundle activates the [Postfinance Flex](https://checkout.postfinance.ch) PaymentGateway in CoreShop.
It requires the [dachcom-digital/payum-postfinance-flex](https://github.com/dachcom-digital/payum-postfinance-flex) repository which will be installed automatically.

## Requirements
CoreShop >= 3.0

## Installation

```json
    "dachcom-digital/payum-postfinance-flex-bundle": "~1.2.0"
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

## Copyright and License
Copyright: [DACHCOM.DIGITAL](https://www.dachcom-digital.ch)
For licensing details please visit [LICENSE.md](LICENSE.md)