<?php
/**
 * Plugin Name: DDI WP Phone
 * Plugin URI: https://www.wplugin.com.br
 * Description: Adiciona um seletor de DDI (código de discagem internacional) com bandeiras de países a campos de telefone em formulários populares do WordPress, aplicando máscaras de telefone dinamicamente.
 * Version: 1.0.0
 * Author: Wplugin
 * Author URI: https://www.wplugin.com.br
 * Text Domain: ddi-wp-phone
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevenir acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// DEFINIR COMO TRUE PARA REABILITAR COM ABORDAGEM SEGURA
define('DDI_WP_PHONE_ENABLED', true);

// Definir constantes do plugin
define('DDI_WP_PHONE_VERSION', '1.0.0');
define('DDI_WP_PHONE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DDI_WP_PHONE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DDI_WP_PHONE_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Incluir a classe principal apenas se estiver habilitado
if (DDI_WP_PHONE_ENABLED) {
    require_once DDI_WP_PHONE_PLUGIN_PATH . 'includes/class-ddi-wp-phone-core.php';
    
    // Inicializar o plugin
    function ddi_wp_phone_init() {
        new DDI_WP_Phone_Core();
    }
    add_action('plugins_loaded', 'ddi_wp_phone_init');
}

// Ativação do plugin
register_activation_hook(__FILE__, 'ddi_wp_phone_activate');
function ddi_wp_phone_activate() {
    // Configurações padrão
    $default_options = array(
        'default_country' => 'BR',
        'show_ddi_code' => true,
        'selector_width' => 60
    );
    
    add_option('ddi_wp_phone_settings', $default_options);
}

// Desativação do plugin
register_deactivation_hook(__FILE__, 'ddi_wp_phone_deactivate');
function ddi_wp_phone_deactivate() {
    // Limpeza se necessário
} 