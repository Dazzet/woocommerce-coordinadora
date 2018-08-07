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

    static function instance(\WcCoordinadora\Webservice\Ags $requester, \WcCoordinadora\Webservice\RequestParameter  $params)
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new self($requester, $params);
        }
        return $obj;
    }

    private function __construct(\WcCoordinadora\Webservice\Ags $requester, \WcCoordinadora\Webservice\RequestParameter  $params)
    {
        $this->requester = $requester;
        $this->params = $params;
    }

    public function start()
    {
        //add_action('woocommerce_order_details_after_order_table', array($this, 'coordinadoraForm'));
        add_action('woocommerce_order_details_after_order_table', array($this, 'orderTrack'));
    }

    public function coordinadoraForm($order)
    {
        $postId = $order->get_data()['id'];
        $code = get_post_meta($postId, 'wc_coordinadora_tracking_code', true);

        if (empty($code)) return;

?>
    <h2><?php _e('Track order with Coordinadora', 'wc-coordinadora') ?></h2>
    <form method="post" action="http://www.coordinadora.com/portafolio-de-servicios/servicios-en-linea/rastrear-guias/" target="_blank">
        <input type="text" name="coor_guia" value="<?php echo $code ?>" readonly="readonly"/>
        <input type="hidden" name="coor_guia_home" value="true">
        <button class="button" type="submit" ><?php _e('Track', 'wc-coordinadora') ?></button>
    </form>
<?php
    }

    public function orderTrack($order)
    {
        $postId = $order->get_data()['id'];
        $code = get_post_meta($postId, 'wc_coordinadora_tracking_code', true);
        $this->params->set('codigo_remision', $code);

        wp_die($this->requester->exe('seguimiento', $this->params));
    }
}
