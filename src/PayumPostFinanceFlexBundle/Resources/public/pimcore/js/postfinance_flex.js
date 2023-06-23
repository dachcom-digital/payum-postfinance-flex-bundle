pimcore.registerNS('coreshop.provider.gateways.postfinance_flex');
coreshop.provider.gateways.postfinance_flex = Class.create(coreshop.provider.gateways.abstract, {

    getLayout: function (config) {

        var optionalFields = [],
            optionalPresets = [
                {
                    name: 'allowedPaymentMethodBrands',
                    defaultValue: '',
                    description: 'https://checkout.postfinance.ch/doc/api/payment-method-brand/list (Add more by using ",")'
                },
            ];

        Ext.Array.each(optionalPresets, function (preset) {

            var fieldName = preset.name,
                defaultValue = preset.defaultValue,
                description = preset.description,
                value = config.optionalParameters && config.optionalParameters[fieldName] ? config.optionalParameters[fieldName] : defaultValue;

            optionalFields.push({
                xtype: 'textfield',
                fieldLabel: t('postfinance_flex.config.optionalParameter.' + fieldName),
                name: 'gatewayConfig.config.optionalParameters.' + fieldName,
                length: 255,
                flex: 1,
                labelWidth: 250,
                anchor: '100%',
                value: value
            });

            if (description !== '') {
                optionalFields.push({
                    xtype: 'label',
                    text: description,
                    value: value,
                    style: 'margin: 5px 0; display:block; padding:2px; background:#f5f5f5; border:1px solid #eee; font-weight: 300; word-wrap:break-word;'
                });
            }
        });

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
            {
                xtype: 'fieldset',
                title: t('postfinance_flex.config.optionalParameter'),
                collapsible: true,
                collapsed: true,
                autoHeight: true,
                labelWidth: 250,
                anchor: '100%',
                flex: 1,
                defaultType: 'textfield',
                items: optionalFields
            }
        ];
    }
});
