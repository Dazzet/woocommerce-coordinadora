<?php namespace WCCoordinadora;

/**
 * Creates the settings page and process the values
 */
class Settings
{

    /** @var string Namespace for the Woocommerce tab */
    const SETTINGS_NAMESPACE = 'wc-coordinadora';

    /** Prevent double initialization */
    private $_initialized = false;

    /**
     * Create an unique object
     */
    static function get()
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
        if (!$this->_initialized) {
            add_action('woocommerce_settings_tabs_array', array($this, 'addSettingsTabs'), 70);
            add_action('woocommerce_settings_tabs_'. self::SETTINGS_NAMESPACE , array($this, 'tabContent'));
            add_action('woocommerce_update_options_'. self::SETTINGS_NAMESPACE, array($this, 'updateSettings' ));
            $this->_initialized = true;
        }

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
            'section_title' => array(
                'name' => __('Section name', 'wc-coordinadora'),
                'type' => 'title',
                'desc' => 'Description',
            ),
            'example_input' => array(
                'name' => __('Example input', 'wc-coordinadora'),
                'type' => 'text',
                'desc' => __('Helper text', 'wc-coordinadora'),
            ),
            'description' => array(
                'name' => __('Textarea field', 'wc-coordinadora'),
                'type' =>'textarea',
                'desc' => __('Textarea desc', 'wc-coordinadora'),
            ),
            'section_end' => array(
                'name' => __('Section end', 'wc-coordinadora'),
                'type' => 'sectionend',
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
