<?php
/**
 * Integração com WooCommerce
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_WooCommerce_Integration {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        add_action('wp_footer', array($this, 'add_woocommerce_script'));
        add_action('woocommerce_after_checkout_form', array($this, 'add_checkout_script'));
        add_action('woocommerce_after_edit_account_form', array($this, 'add_account_script'));
    }
    
    /**
     * Adiciona script específico para WooCommerce
     */
    public function add_woocommerce_script() {
        if (!$this->should_load_woocommerce_script()) {
            return;
        }
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Processar campos de telefone do WooCommerce
            DDIWpPhone.processWooCommerceForms();
            
            // Observar mudanças no checkout
            $(document.body).on('updated_checkout', function() {
                DDIWpPhone.processWooCommerceForms();
            });
            
            // Observar mudanças na conta
            $(document.body).on('updated_account_details', function() {
                DDIWpPhone.processWooCommerceForms();
            });
        });
        </script>
        <?php
    }
    
    /**
     * Adiciona script específico para checkout
     */
    public function add_checkout_script() {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Processar campos de telefone do checkout
            DDIWpPhone.processWooCommerceForms();
        });
        </script>
        <?php
    }
    
    /**
     * Adiciona script específico para página de conta
     */
    public function add_account_script() {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Processar campos de telefone da conta
            DDIWpPhone.processWooCommerceForms();
        });
        </script>
        <?php
    }
    
    /**
     * Verifica se deve carregar scripts do WooCommerce
     */
    private function should_load_woocommerce_script() {
        if (!class_exists('WooCommerce')) {
            return false;
        }
        
        return is_checkout() || is_account_page();
    }
} 