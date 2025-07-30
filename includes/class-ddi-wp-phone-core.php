<?php
/**
 * Classe Principal do Plugin DDI WP Phone
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_Core {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->init_hooks();
        $this->load_dependencies();
    }
    
    /**
     * Inicializa os hooks do WordPress
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Carrega as dependências do plugin
     */
    private function load_dependencies() {
        // Classe de assets
        require_once DDI_WP_PHONE_PLUGIN_PATH . 'includes/class-ddi-wp-phone-assets.php';
        
        // Integrações
        require_once DDI_WP_PHONE_PLUGIN_PATH . 'integrations/class-elementor-integration.php';
        require_once DDI_WP_PHONE_PLUGIN_PATH . 'integrations/class-cf7-integration.php';
        require_once DDI_WP_PHONE_PLUGIN_PATH . 'integrations/class-woocommerce-integration.php';
        
        // Admin
        if (is_admin()) {
            require_once DDI_WP_PHONE_PLUGIN_PATH . 'admin/class-admin-settings.php';
        }
    }
    
    /**
     * Inicialização do plugin
     */
    public function init() {
        // Carregar text domain para internacionalização
        load_plugin_textdomain('ddi-wp-phone', false, dirname(DDI_WP_PHONE_PLUGIN_BASENAME) . '/languages');
        
        // Inicializar integrações
        new DDI_WP_Phone_Elementor_Integration();
        new DDI_WP_Phone_CF7_Integration();
        new DDI_WP_Phone_WooCommerce_Integration();
        
        // Inicializar admin se necessário
        if (is_admin()) {
            new DDI_WP_Phone_Admin_Settings();
        }
    }
    
    /**
     * Enfileira scripts e estilos
     */
    public function enqueue_scripts() {
        // Verificar se há formulários na página
        if ($this->should_load_assets()) {
            $assets = new DDI_WP_Phone_Assets();
            $assets->enqueue_frontend_assets();
        }
    }
    
    /**
     * Verifica se deve carregar os assets
     */
    private function should_load_assets() {
        // Verificar se há formulários do Elementor
        if (class_exists('Elementor\Plugin') && $this->has_elementor_forms()) {
            return true;
        }
        
        // Verificar se há formulários do Contact Form 7
        if (class_exists('WPCF7') && $this->has_cf7_forms()) {
            return true;
        }
        
        // Verificar se é página do WooCommerce
        if (class_exists('WooCommerce') && (is_checkout() || is_account_page())) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Verifica se há formulários do Elementor na página
     */
    private function has_elementor_forms() {
        global $post;
        
        if (!$post) {
            return false;
        }
        
        // Verificar se o post foi criado com Elementor
        if (class_exists('Elementor\Plugin')) {
            $document = \Elementor\Plugin::$instance->documents->get($post->ID);
            if ($document && $document->is_built_with_elementor()) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Verifica se há formulários do Contact Form 7 na página
     */
    private function has_cf7_forms() {
        global $post;
        
        if (!$post) {
            return false;
        }
        
        // Verificar se há shortcodes do CF7 no conteúdo
        return has_shortcode($post->post_content, 'contact-form-7');
    }
} 