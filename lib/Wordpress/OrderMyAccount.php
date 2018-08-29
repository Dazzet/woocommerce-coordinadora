<?php namespace WcCoordinadora\Wordpress;

/**
 * Creates the options inside the MyAccount page
 */
class OrderMyAccount
{
    /** @var \WcCoordinadora\Webservice\Ags Executed the request */
    protected $requester;

    /** @var \WcCoordinadora\Webservice\RequestParameter paramters for the requester */
    protected $params;

    protected $jsHandle = 'wc-coordinadora-js';

    static function instance( \WcCoordinadora\Webservice\Ags $requester,
        \WcCoordinadora\Webservice\RequestParameter  $params)
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new self($requester, $params);
        }
        return $obj;
    }

    private function __construct( \WcCoordinadora\Webservice\Ags $requester,
        \WcCoordinadora\Webservice\RequestParameter  $params)
    {
        $this->requester = $requester;
        $this->params = $params;
    }

    public function start()
    {

        // Register ajax response funciton
        add_action('wp_ajax_wc_coordinadora', array($this, 'ajaxResponse'));
        add_action('wp_ajax_nopriv_wc_coordinadora', array($this, 'ajaxResponse'));

        // Create the form
        add_action('woocommerce_order_details_after_order_table', array($this, 'coordinadoraForm'));
    }

    public function coordinadoraForm($order)
    {
        $postId = $order->get_data()['id'];
        $code = get_post_meta($postId, 'wc_coordinadora_tracking_code', true);

        if (empty($code)) return;

        wp_register_script($this->jsHandle, plugin_dir_url(dirname(__DIR__)) . 'js/wc-coordinadora.js', array('jquery'), null, true);
        wp_register_script('js-base64', 'https://cdn.jsdelivr.net/npm/js-base64@2/base64.min.js', null, true);
        wp_localize_script($this->jsHandle, 'wc_coordinadora', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'code' => $code,
            'spinner' => plugin_dir_url(dirname(__DIR__)) . 'images/spinner.gif'
        ));
        wp_enqueue_script('js-base64');
        wp_enqueue_script($this->jsHandle);

?>
    <h2><?php _e('Track order with Coordinadora', 'wc-coordinadora') ?></h2>
    <form method="post" id="wc-coordinadora-track-my-order">
        <button class="button track-button" type="submit"><?php _e('Track', 'wc-coordinadora') ?></button>
    </form>
    <div id="wc-coordinadora-track-result"></div>
<?php
    }


    public function ajaxResponse()
    {
        $this->params->set('codigo_remision', '85110000010');
        $res = $this->requester->get('seguimiento')
                    ->with($this->params)
                    ->exe()
                    ->result();
        wp_send_json($res);

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}
