<?php namespace WCCoordinadora;

class Order
{
    private $_initialized;

    static function get()
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new Order;
        }
        return $obj;
    }

    public function test()
    {
        echo 'hola';

        return $this;
    }

    private function __construct()
    {
        if (!$this->_initialized) {
            add_action('add_meta_boxes', array($this, 'addMetaboxes'), 10, 2);
            add_action('woocommerce_process_shop_order_meta', array($this, 'processShopOrderMeta'), 10, 2);
            add_action('save_post', array($this, 'savePost'), 10, 2);
        }

    }

    public function addMetaboxes()
    {
        add_meta_box(
            'wc-coordinadora-tracking',
            __('Coordinadora Mercantil Tracking', 'wc-coordinadora'),
            array($this, 'metaboxTracking'),
            'shop_order', // screen
            'side', // context
            'high' // priority
        );

    }

    public function metaboxTracking( $post )
    {
        $data = get_post_meta($post->ID, 'wc_coordinadora_tracking_code', true);
        echo '<p><input type="text" name="wc_coordinadora_tracking_code" placeholder="ABC123" value="'.$data.'"></p>';
    }

    public function savePost($id, $post )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $id;
        }
        update_post_meta($id, 'wc_coordinadora_tracking_code', $_POST['wc_coordinadora_tracking_code']);
    }


}
