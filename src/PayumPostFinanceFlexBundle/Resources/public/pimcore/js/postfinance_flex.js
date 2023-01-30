pimcore.registerNS('coreshop.provider.gateways.postfinance_flex');
coreshop.provider.gateways.postfinance_flex = Class.create(coreshop.provider.gateways.abstract, {

    getLayout: function (config) {

        var storeEnvironments = new Ext.data.ArrayStore({
            fields: ['environment', 'environmentName'],
            data: [
                ['test', 'Test'],
                ['production', 'Production']
            ]
        });

        return [
            {
                xtype: 'combobox',
                fieldLabel: t('postfinance.config.environment'),
                name: 'gatewayConfig.config.environment',
                value: config.environment ? config.environment : '',
                store: storeEnvironments,
                triggerAction: 'all',
                valueField: 'environment',
                displayField: 'environmentName',
                mode: 'local',
                forceSelection: true,
                selectOnFocus: true
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.spaceId'),
                name: 'gatewayConfig.config.spaceId',
                length: 255,
                value: config.spaceId ? config.spaceId : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.postFinanceUserId'),
                name: 'gatewayConfig.config.postFinanceUserId',
                length: 255,
                value: config.postFinanceUserId ? config.postFinanceUserId : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.postFinanceSecret'),
                name: 'gatewayConfig.config.postFinanceSecret',
                length: 255,
                value: config.postFinanceSecret ? config.postFinanceSecret : ""
            },
        ];
    }
});
