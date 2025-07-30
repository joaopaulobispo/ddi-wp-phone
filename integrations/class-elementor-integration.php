<?php
/**
 * Integração com Elementor Pro
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_Elementor_Integration {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        add_action('wp_footer', array($this, 'add_elementor_script'));
        add_action('elementor/frontend/after_render', array($this, 'process_elementor_form'), 10, 2);
    }
    
    /**
     * Adiciona script específico para Elementor
     */
    public function add_elementor_script() {
        if (!$this->has_elementor_forms()) {
            return;
        }
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Aguardar o Elementor carregar completamente
            $(window).on('elementor/frontend/init', function() {
                // Processar formulários existentes
                DDIWpPhone.processElementorForms();
                
                // Observar mudanças dinâmicas
                elementorFrontend.hooks.addAction('frontend/element_ready/form.default', function($scope) {
                    DDIWpPhone.processElementorForms();
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * Processa formulários do Elementor após renderização
     */
    public function process_elementor_form($element, $args) {
        if ($element->get_name() === 'form') {
            // O JavaScript principal irá processar os campos
            // Esta função é chamada após cada renderização de formulário
        }
    }
    
    /**
     * Verifica se há formulários do Elementor na página
     */
    private function has_elementor_forms() {
        global $post;
        
        if (!$post) {
            return false;
        }
        
        // Verificar se o Elementor está ativo
        if (!class_exists('Elementor\Plugin')) {
            return false;
        }
        
        // Verificar se o post foi criado com Elementor
        $document = \Elementor\Plugin::$instance->documents->get($post->ID);
        if (!$document || !$document->is_built_with_elementor()) {
            return false;
        }
        
        // Verificar se há widgets de formulário
        $data = $document->get_elements_data();
        return $this->has_form_widget($data);
    }
    
    /**
     * Verifica recursivamente se há widgets de formulário
     */
    private function has_form_widget($elements) {
        if (!is_array($elements)) {
            return false;
        }
        
        foreach ($elements as $element) {
            if (isset($element['widgetType']) && $element['widgetType'] === 'form') {
                return true;
            }
            
            if (isset($element['elements']) && is_array($element['elements'])) {
                if ($this->has_form_widget($element['elements'])) {
                    return true;
                }
            }
        }
        
        return false;
    }
} 