import { __ } from '@wordpress/i18n';

export default [
    {
        id: 'catalog',
        name: __("Catalog Showcase", "catalogx"),
        desc: "<fieldset><legend><i class='adminLib-pro-tab'></i> Pro</legend><span>Ideal for showcasing products by hiding prices, disabling purchases, and restricting cart/checkout access.</span></fieldset>",
        icon: 'adminLib-catalog',
        doc_link: 'https://catalogx.com/docs/catalog/?utm_source=wpadmin&utm_medium=pluginsettings&utm_campaign=catalogx',
        settings_link: appLocalizer.site_url,
        pro_module: true,
    },
    {
        id: 'enquiry',
        name: __("Enquiry & Communication", "catalogx"),
        desc: "<fieldset><legend>Free</legend><span>Add enquiry button for single product email enquiries to admin.</span></fieldset><fieldset><legend><i class='adminLib-pro-tab'></i> Pro</legend><span>Full messaging hub with two-way communication, multi-product enquiries, and centralized management.</span></fieldset>",
        icon: 'adminLib-inquiry',
        doc_link: 'https://catalogx.com/docs/enquiry-communication/?utm_source=wpadmin&utm_medium=pluginsettings&utm_campaign=catalogx',
        settings_link: appLocalizer.site_url,
        pro_module: false
    },
    {
        id: 'quote',
        name: __("Quotation", "catalogx"),
        desc: "<fieldset><legend>Free</legend><span>Add quotation button for customers to request product quotes via email.</span></fieldset><fieldset><legend><i class='adminLib-pro-tab'></i> Pro</legend><span>Manage quotations with dedicated list views, generate and monitor quotes from admin panel, offer PDF downloads, and set expiry dates.</span></fieldset>",
        icon: 'adminLib-price-quote-icon',
        doc_link: 'https://catalogx.com/docs/quotation/?utm_source=wpadmin&utm_medium=pluginsettings&utm_campaign=catalogx',
        settings_link: appLocalizer.site_url,
        pro_module: false
    },
    {
        id: 'wholesale',
        name: __("Wholesale Pricing", "catalogx;"),
        desc: "<fieldset><legend><i class='adminLib-pro-tab'></i> Pro</legend><span>Custom wholesale registration forms builder, admin approval, wholesale order lists, and coupon restrictions for wholesale users.</span></fieldset>",
        icon: 'adminLib-warehousing-icon',
        doc_link: 'https://catalogx.com/docs/wholesale-pricing/?utm_source=wpadmin&utm_medium=pluginsettings&utm_campaign=catalogx',
        settings_link: appLocalizer.wholesale_settings_url,
        pro_module: true
    },
    {
        id: 'rules',
        name: __("Dynamic Pricing Rules", "catalogx"),
        desc: "<fieldset><legend><i class='adminLib-pro-tab'></i> Pro</legend><span>You can set up various rules to modify the prices of different categories and products in bulk, targeting specific customers and user roles.</span></fieldset>",
        icon: 'adminLib-dynamic-pricing',
        doc_link: 'https://catalogx.com/docs/dynamic-pricing-rules/?utm_source=wpadmin&utm_medium=pluginsettings&utm_campaign=catalogx',
        settings_link: appLocalizer.rule_url,
        pro_module: true
    },
]