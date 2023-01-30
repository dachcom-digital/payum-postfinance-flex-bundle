<?php

namespace PayumPostFinanceFlexBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class PayumPostFinanceFlexBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    protected function getComposerPackageName(): string
    {
        return 'dachcom-digital/payum-postfinance-flex-bundle';
    }
}
