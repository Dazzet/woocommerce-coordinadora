<?php namespace WcCoordinadora\Wordpress;

/**
 * Creates the options inside the MyAccount page
 */
class OrderMyAccount
{
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
        add_action('woocommerce_order_details_after_order_table', array($this, 'deliveryInfo'));
    }

    public function deliveryInfo($order)
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
}
