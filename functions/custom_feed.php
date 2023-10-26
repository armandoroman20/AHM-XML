<?php 

function generate_orders_xml_feed() {
    header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);

    echo '<?xml version="1.0"?>';
	echo '<SparkLink environment="Production" lang="en" Rev="" TransId="">';
	echo  '<header>';
    echo '<orders>';

    // Get WooCommerce orders

    $orders = wc_get_orders(array(
//         'status' => 'completed', // You can change the order status as needed
        'limit' => -1, // Retrieve all orders
    ));

    foreach ($orders as $order) {
        $order_id = $order->get_id();
        $order_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $address_line_1 = $order->get_billing_address_1();

        echo '<order>';
        echo '<id>' . esc_html($order_id) . '</id>';
        echo '<name>' . esc_html($order_name) . '</name>';
        echo '<address_line_1>' . esc_html($address_line_1) . '</address_line_1>';
        echo '</order>';
    }

    echo '</orders>';
	echo '</header>';
	echo '</SparkLink>';
    exit;
}

// Hook the function to a custom endpoint
function customSparklinkFeed() { //initialize the feed
	add_feed('sparklink-feed','generate_orders_xml_feed');
}
add_action('init', 'customSparklinkFeed');