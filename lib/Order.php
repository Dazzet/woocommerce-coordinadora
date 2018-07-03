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
        $data = get_post_custom($post->ID);
        if (!isset($data['wc_coordinadora_tracking_code'])) {
            $data['wc_coordinadora_tracking_code'] = '';
        }
        ?>
<div class="wc-coordinadora-track-infomation">
<p>
<label for="wc-coordinadora-tracking-code"><?php _e('Tracking Code', 'wc-coordinadora'); ?></label>
<input type="text" name="wc_coordinadora_tracking_code" id="wc-coordinadora-tracking-code" placeholder="ABC1234" value="<?php echo $data['wc_coordinadora_tracking_code'] ?>" />
</p>

</div>


        <?php
    }

    public function processShopOrderMeta($id, $post )
    {
        $order = wc_get_order($id);
        //wp_die(print_r($order, true));
    }


}
