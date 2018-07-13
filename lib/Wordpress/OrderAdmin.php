<?php namespace WCCoordinadora\Wordpress;

/**
 * Create a meta-box on the order page
 */
class OrderAdmin
{
    private $_initialized = false;

    static function instance()
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new self();
        }
        return $obj;
    }

    private function __construct()
    {

    }

    public function start()
    {
        if (!$this->_initialized) {
            add_action('add_meta_boxes', array($this, 'addMetaboxes'), 10, 2);
            add_action('woocommerce_process_shop_order_meta', array($this, 'processShopOrderMeta'), 10, 2);
            add_action('save_post', array($this, 'savePost'), 10, 2);
            $this->_initialized = true;
        }

        return $this;
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

        return $this;

    }

    public function metaboxTracking( $post )
    {
        $data = get_post_meta($post->ID, 'wc_coordinadora_tracking_code', true);
        echo '<p><input type="text" name="wc_coordinadora_tracking_code" placeholder="ABC123" value="'.$data.'"></p>';

        return $this;
    }

    public function savePost($id, $post )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $id;
        }
        update_post_meta($id, 'wc_coordinadora_tracking_code', $_POST['wc_coordinadora_tracking_code']);

        return $this;
    }


}
