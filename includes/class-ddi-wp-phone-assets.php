<?php
/**
 * Classe para gerenciar assets do plugin
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_Assets {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }
    
    /**
     * Enfileira assets do frontend
     */
    public function enqueue_frontend_assets() {
        // CSS principal
        wp_enqueue_style(
            'ddi-wp-phone-main',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/css/ddi-wp-phone-main.css',
            array(),
            DDI_WP_PHONE_VERSION
        );
        
        // CSS das bandeiras
        wp_enqueue_style(
            'flag-icons',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/css/flag-icons.min.css',
            array(),
            DDI_WP_PHONE_VERSION
        );
        
        // JavaScript da biblioteca libphonenumber
        wp_enqueue_script(
            'libphonenumber-js',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/js/libphonenumber-js.min.js',
            array(),
            DDI_WP_PHONE_VERSION,
            true
        );
        
        // JavaScript principal
        wp_enqueue_script(
            'ddi-wp-phone-main',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/js/ddi-wp-phone-main.js',
            array('jquery', 'libphonenumber-js'),
            DDI_WP_PHONE_VERSION,
            true
        );
        
        // Localizar script com configurações
        $this->localize_script();
    }
    
    /**
     * Enfileira assets do admin
     */
    public function enqueue_admin_assets($hook) {
        // Apenas na página de configurações do plugin
        if ($hook !== 'settings_page_ddi-wp-phone-settings') {
            return;
        }
        
        wp_enqueue_style(
            'ddi-wp-phone-admin',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/css/ddi-wp-phone-admin.css',
            array(),
            DDI_WP_PHONE_VERSION
        );
        
        wp_enqueue_script(
            'ddi-wp-phone-admin',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/js/ddi-wp-phone-admin.js',
            array('jquery'),
            DDI_WP_PHONE_VERSION,
            true
        );
    }
    
    /**
     * Localiza o script com configurações
     */
    private function localize_script() {
        $settings = get_option('ddi_wp_phone_settings', array());
        
        $script_data = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ddi_wp_phone_nonce'),
            'settings' => array(
                'default_country' => isset($settings['default_country']) ? $settings['default_country'] : 'BR',
                'show_ddi_code' => isset($settings['show_ddi_code']) ? (bool) $settings['show_ddi_code'] : true,
                'selector_width' => isset($settings['selector_width']) ? (int) $settings['selector_width'] : 60
            ),
            'strings' => array(
                'select_country' => __('Select Country', 'ddi-wp-phone'),
                'invalid_phone' => __('Invalid phone number', 'ddi-wp-phone')
            )
        );
        
        wp_localize_script('ddi-wp-phone-main', 'ddiWpPhone', $script_data);
    }
} 