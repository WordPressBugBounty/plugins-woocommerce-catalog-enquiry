import { __ } from '@wordpress/i18n';

export default {
    id: 'pages',
    priority: 80,
    name: __("Page Endpoint", "catalogx"),
    desc: __("Manage the endpoints for all pages on the site, ensuring proper routing and access.", "catalogx"),
    icon: 'adminLib-book',
    submitUrl: 'settings',
    modal : [
        {
            key: 'set_enquiry_cart_page',
            type: 'select',
            label: __("Set Enquiry Cart Page", "catalogx"),
            desc: __("Select the page on which you have inserted <code>[catalogx_enquiry_cart]</code> shortcode.", "catalogx"),
            options: appLocalizer.all_pages,
            proSetting: true,
        },
        {
            key: 'set_request_quote_page',
            type: 'select',
            label: __("Set Request Quote Page", "catalogx"),
            desc: __("Select the page on which you have inserted <code>[request_quote]</code> shortcode.", "catalogx"),
            options: appLocalizer.all_pages,
            proSetting: true,
        },
        {
            key: 'set_wholesale_products_page',
            type: 'select',
            label: __("Set Wholesale Products Page", "catalogx"),
            desc: __("Select the page on which you have inserted <code>[catalogx_wholesale_products]</code> shortcode.", "catalogx"),
            options: appLocalizer.all_pages,
            proSetting: true,
        },
        {
            key: 'separator_content',
            type: 'section',
            label: "",
        },
        {
            key: 'shortCode',
            type: 'shortCode-table',
            label: __("Available Shortcodes", "catalogx"),
            desc: __('', "catalogx"),
            optionLabel: [
                'Shortcodes',
                'Description',
            ],
            option: [
                {
                    key: '',
                    label: '[catalogx_enquiry_cart]',
                    desc: 'Display all products in the enquiry cart and send a single inquiry email for all items in the cart.',
                },
                {
                    key: '',
                    label: '[catalogx_request_quote]',
                    desc: 'Displays a list of products for which users have requested quotes, making it easy to review all requests.',
                },
                {
                    key: '',
                    label: '[catalogx_wholesale_products]',
                    desc: 'Creates a page listing all wholesale products, enabling wholesalers to easily purchase multiple items in one transaction.',
                },
                {
                    key: '',
                    label: '[catalogx_enquiry_cart_button]',
                    desc: 'Displays the "Add to Enquiry Cart" button.',
                },
                {
                    key: '',
                    label: '[catalogx_enquiry_button]',
                    desc: 'Displays the "Send an Enquiry" button',
                },
                {
                    key: '',
                    label: '[catalogx_quote_button]',
                    desc: 'Displays the "Add to Quote" button.',
                },
            ]
        }
    ]
}