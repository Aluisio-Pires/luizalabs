export default {
    install(app, options) {
        const locale = options.locale || 'pt-BR';
        const formatOptions = options.formatOptions || {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        };

        app.config.globalProperties.$formatNumber = (value) => {
            if (typeof value !== 'number') return value;
            return new Intl.NumberFormat(locale, formatOptions).format(value);
        };
    },
};
