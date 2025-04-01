<?php
/**
 * CatalogX Email Request quote
 * 
 * Override this template by copying it to yourtheme/woocommerce-catalog-enquiry/emails/request-quote.php
 *
 * @author    MultiVendorX
 * @package   woocommerce-catalog-enquiry/templates
 * @version   6.0.0
 */
defined( 'ABSPATH'  ) || exit; // Exit if accessed directly

do_action( 'catalogx_email_header', $email_heading  ); 
$customer_data = $args['customer_data'];
?>
<body>
    <div style="width:600px; margin: 0 auto; ">

<div class="email-container" style="border: 1px solid #557DA1;">
    <div style="background: #557DA1; padding: 30px 30px; border: 1px solid #557DA1;">
           <h2 style="font-family: Arial; line-height: 43px; text-align: center; color: #fff; font-size: 46px; font-weight: 700; margin: 0;padding: 0 0 0px 0;"><?php printf( __( 'Dear %s', 'catalogx' ), $admin ); ?> </h2>
           <p style=" color:#fff; margin-bottom:0; text-align: center; font-size:16px; "><?php _e( 'You have received a new quote request from a customer for the following product:', 'catalogx' ); ?></p>
    </div>
    
    <div style="padding: 20px;">
    <div class="table-wrapper">
        <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
            <thead>
                <tr>
                    <th scope="col"style="text-align:<?php echo esc_attr( $text_align ); ?>; border: 1px solid #eee;">
                        <?php esc_html_e( 'Product', 'catalogx');?>
                    </th>
                    <th scope="col" style="text-align:center; border: 1px solid #eee;">
                        <?php esc_html_e( 'Qty', 'catalogx'); ?>
                    </th>
                    <th scope="col" style="text-align:center; border: 1px solid #eee;">
                        <?php esc_html_e( 'Price', 'catalogx'); ?>
                    </th>
                </tr>
            </thead>

            <tbody>
            <?php
                foreach ( $args['products'] as $item  ) {
                    $_product = wc_get_product( $item['product_id'] );
                ?>
                <tr>
                    <td class="product_name" style="border:none;">
                    <a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo $_product->get_title(); ?></a>
                    </td>
                    <td class="product_quantity" style="border:none;">
                        <?php echo esc_html( $item['quantity'] ); ?>
                    </td>
                    <td class="product_quantity" style="border:none;">
                        <?php echo wc_price( $_product->get_regular_price() ); ?>
                    </td>
                </tr>
                <?php 
                } ?>
            </tbody>
        </table>
        <br>
    </div>
    <div class="details">
        <p><strong><?php _e( 'Customer Name:', 'catalogx' ); ?></strong> <?php echo esc_html( $customer_data['name'] ); ?></p>
        <p><strong><?php _e('Email:', 'catalogx'); ?></strong> 
        <a href="mailto:<?php echo esc_attr($customer_data['email']); ?>">
            <?php echo esc_html($customer_data['email']); ?>
        </a></p>
        <?php if (!empty($customer_data['details'])) { ?>
            <p><strong><?php _e('Additional Details:', 'catalogx'); ?></strong><br>
                <?php echo nl2br(esc_html($customer_data['details'])); ?>
            </p>
        <?php } ?>

    </div>
    </div>
</div>
</div>
</body>

<?php do_action( 'catalogx_email_footer', $email ); ?>