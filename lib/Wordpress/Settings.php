<?php namespace WcCoordinadora\Wordpress;

/**
 * Creates the settings page in Woocommerce > Settings > Coordinadora and process the values
 */
class Settings
{

    /** @var string Namespace for the Woocommerce tab */
    const SETTINGS_NAMESPACE = 'wc-coordinadora';

    /**
     * Create an unique object
     */
    static function instance()
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new Settings();
        }

        return $obj;
    }

    /**
     *  Initialize
     */
    private function __construct()
    {

    }

    public function start()
    {
        add_action('woocommerce_settings_tabs_array', array($this, 'addSettingsTabs'), 70);
        add_action('woocommerce_settings_tabs_'. self::SETTINGS_NAMESPACE , array($this, 'tabContent'));
        add_action('woocommerce_update_options_'. self::SETTINGS_NAMESPACE, array($this, 'updateSettings' ));

        return $this;
    }

    /**
     * Create the tabs on Woocommerce > Settings > Coordinadora
     */
    public function addSettingsTabs($tabs)
    {
        $tabs[self::SETTINGS_NAMESPACE] = __('Coordinadora', 'wc-coordinadora');
        return $tabs;
    }

    /**
     * Fill the tab with content
     */
    public function tabContent()
    {
        woocommerce_admin_fields( $this->getFields() );
    }

    /**
     * Handle the save data
     */
    public function updateSettings()
    {
        woocommerce_update_options( $this->getFields() );
    }

    /**
     * Function for the creation of the content and update information
     */
    private function getFields()
    {
        $fields = array(
            'client_info_start' => array(
                'name' => __('Business info', 'wc-coordinadora'),
                'type' => 'title',
                'desc' => __('Business information required for the WebService'),
            ),
            'client_id' => array(
                'name' => __('Client NIT', 'wc-coordinadora'),
                'type' => 'text',
                'desc' => __('Your business ID or NIT (For Colombia)', 'wc-coordinadora'),
                'placeholder' => '123456789'
            ),
            'client_div' => array(
                'name' => __('Client Division', 'wc-coordinadora'),
                'type' => 'text',
                'desc' => __('', 'wc-coordinadora'),
            ),
            'client_info_end' => array(
                'name' => __('Section end', 'wc-coordinadora'),
                'type' => 'sectionend',
            ),
            'api_info_start' => array(
                'name' => __('Webservice information', 'wc-coordinadora'),
                'type' => 'title',
                'desc' => __('This information should be provided by Coordinadora', 'wc-coordinadora')
            ),
            'api_key' => array(
                'name' => __('Api Key', 'wc-coordinadora'),
                'type' => 'text',
                'placeholder' => '00000000-0000-0000-0000-000000000000'
            ),
            'api_pass' => array(
                'name' => __('Api Password', 'wc-coordinadora'),
                'type' => 'password'

            ),
            'api_tracking_wsdl' => array(
                'name' => __('WSDL for package tracking', 'wc-coordinadora'),
                'type' => 'text',
                'default' => 'http://sandbox.coordinadora.com/ags/1.4/server.php?wsdl',
                'placeholder' => 'http://sandbox.coordinadora.com/ags/1.4/server.php?wsdl',
                'desc' => __('Leave the default if you are not sure', 'wc-coordinadora')
            ),
            'api_info_end' => array(
                'name' => __('Section End', 'wc-coordinadora'),
                'type' => 'sectionend'
            )
        );

        foreach ($fields as $key => $val ) {
            $fields[$key]['id'] = self::SETTINGS_NAMESPACE . '-'.$key;
        }

        return apply_filters('wc_settings_tab_'.self::SETTINGS_NAMESPACE, $fields);
    }

    /**
     * Get a woocommerce option making sure that the assigned filters get
     * fired first
     */
    public function option( $key, $default = null )
    {
        $fields = $this->getFields();

        if (is_null($default) && isset($fields[$key]['default'])) {
            $default = $fields[$key]['default'];
        }
        return apply_filters( 'wc_option_' . $key, get_option( self::SETTINGS_NAMESPACE . '-' . $key,  $default ) );
    }

}
