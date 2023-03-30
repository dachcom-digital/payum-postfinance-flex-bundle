pimcore.registerNS('coreshop.provider.gateways.postfinance_flex');
coreshop.provider.gateways.postfinance_flex = Class.create(coreshop.provider.gateways.abstract, {

    getLayout: function (config) {

        return [
            {
                xtype: 'checkbox',
                fieldLabel: t('postfinance.config.sandbox'),
                name: 'gatewayConfig.config.sandbox',
                value: config.sandbox ? config.sandbox : false,
                inputValue: true,
                uncheckedValue: false,
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.spaceId'),
                name: 'gatewayConfig.config.spaceId',
                length: 255,
                value: config.spaceId ? config.spaceId : ''
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.postFinanceUserId'),
                name: 'gatewayConfig.config.postFinanceUserId',
                length: 255,
                value: config.postFinanceUserId ? config.postFinanceUserId : ''
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.postFinanceSecret'),
                name: 'gatewayConfig.config.postFinanceSecret',
                length: 255,
                value: config.postFinanceSecret ? config.postFinanceSecret : ''
            },
        ];
    }
});
