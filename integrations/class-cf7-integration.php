<?php
/**
 * Integração com Contact Form 7
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_CF7_Integration {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        add_action('wp_footer', array($this, 'add_cf7_script'));
        add_action('wpcf7_enqueue_scripts', array($this, 'enqueue_cf7_scripts'));
    }
    
    /**
     * Adiciona script específico para CF7
     */
    public function add_cf7_script() {
        if (!$this->has_cf7_forms()) {
            return;
        }
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Processar formulários CF7 existentes
            DDIWpPhone.processCF7Forms();
            
            // Observar novos formulários carregados via AJAX
            $(document).on('wpcf7:mailsent', function() {
                DDIWpPhone.processCF7Forms();
            });
            
            $(document).on('wpcf7:invalid', function() {
                DDIWpPhone.processCF7Forms();
            });
        });
        </script>
        <?php
    }
    
    /**
     * Enfileira scripts específicos para CF7
     */
    public function enqueue_cf7_scripts() {
        // Os scripts principais já são carregados pela classe de assets
        // Esta função pode ser usada para scripts específicos do CF7 se necessário
    }
    
    /**
     * Verifica se há formulários do CF7 na página
     */
    private function has_cf7_forms() {
        global $post;
        
        if (!$post) {
            return false;
        }
        
        // Verificar se o CF7 está ativo
        if (!class_exists('WPCF7')) {
            return false;
        }
        
        // Verificar se há shortcodes do CF7 no conteúdo
        return has_shortcode($post->post_content, 'contact-form-7');
    }
} 