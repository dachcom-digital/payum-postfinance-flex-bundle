# CoreShop PostFinfance FLex Payum Connector
This Bundle activates the Postfinance Flex PaymentGateway in CoreShop.
It requires the [dachcom-digital/payum-postfinance-flex](https://github.com/dachcom-digital/payum-postfinance-flex) repository which will be installed automatically.

## Requirements
CoreShop >= 3.0

## Installation

#### 1. Composer
```json
    "dachcom-digital/payum-postfinance-flex-bundle": "~1.0.0"
```

#### 2. Activate
Enable the Bundle in Pimcore Extension Manager

#### 3. Setup
Go to CoreShop -> PaymentProvider and add a new Provider. Choose `postfinance_flex` from `type` and fill out the required fields.

## Changelog
--

## Copyright and License
Copyright: [DACHCOM.DIGITAL](https://www.dachcom-digital.ch)
For licensing details please visit [LICENSE.md](LICENSE.md)