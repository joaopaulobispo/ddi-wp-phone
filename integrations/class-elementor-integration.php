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
        // Usar hooks do Elementor de forma mais segura
        add_action('elementor/frontend/after_render', array($this, 'after_element_render'), 10, 2);
        add_action('wp_footer', array($this, 'add_elementor_script'), 999);
    }
    
    /**
     * Após renderização de elementos do Elementor
     */
    public function after_element_render($element, $args) {
        // Verificar se é um widget de formulário
        if ($element->get_name() === 'form') {
            // Não fazer nada aqui, deixar o JavaScript fazer o trabalho
        }
    }
    
    /**
     * Adiciona script específico para Elementor
     */
    public function add_elementor_script() {
        // Verificar se há formulários do Elementor na página
        if (!$this->has_elementor_forms()) {
            return;
        }
        
        // Adicionar script apenas se necessário
        ?>
        <script>
        (function() {
            'use strict';
            
            // Aguardar o Elementor carregar completamente
            function waitForElementor() {
                if (typeof elementorFrontend !== 'undefined') {
                    // Elementor carregado, processar formulários
                    processElementorForms();
                } else {
                    // Aguardar mais um pouco
                    setTimeout(waitForElementor, 100);
                }
            }
            
            // Processar formulários do Elementor
            function processElementorForms() {
                try {
                    // Procurar por campos de telefone do Elementor
                    var phoneFields = document.querySelectorAll('.elementor-field-type-tel input[type="tel"]');
                    
                    if (phoneFields.length > 0) {
                        console.log('DDI WP Phone: Encontrados', phoneFields.length, 'campos de telefone do Elementor');
                        
                        phoneFields.forEach(function(field, index) {
                            processPhoneField(field);
                        });
                    }
                } catch (error) {
                    console.error('DDI WP Phone: Erro ao processar formulários Elementor:', error);
                }
            }
            
            // Processar um campo de telefone
            function processPhoneField(field) {
                try {
                    // Verificar se já foi processado
                    if (field.classList.contains('ddi-wp-phone-processed')) {
                        return;
                    }
                    
                    // Marcar como processado
                    field.classList.add('ddi-wp-phone-processed');
                    
                    // Criar container
                    var container = document.createElement('div');
                    container.className = 'ddi-wp-phone-container';
                    container.style.position = 'relative';
                    container.style.display = 'inline-block';
                    container.style.width = '100%';
                    
                    // Envolver o campo
                    field.parentNode.insertBefore(container, field);
                    container.appendChild(field);
                    
                    // Criar seletor
                    var selector = document.createElement('div');
                    selector.className = 'ddi-wp-phone-selector';
                    selector.innerHTML = '🇧🇷 +55';
                    selector.style.cssText = 'position: absolute; left: 0; top: 0; bottom: 0; z-index: 10; display: flex; align-items: center; background: #fff; border: 1px solid #ddd; border-right: none; border-radius: 4px 0 0 4px; cursor: pointer; min-width: 60px; padding: 0 8px; font-size: 14px; color: #333; font-weight: 500;';
                    
                    // Inserir seletor
                    container.insertBefore(selector, field);
                    
                    // Adicionar padding ao campo
                    field.style.paddingLeft = '70px';
                    
                    console.log('DDI WP Phone: Campo processado com sucesso');
                    
                } catch (error) {
                    console.error('DDI WP Phone: Erro ao processar campo:', error);
                }
            }
            
            // Iniciar quando o DOM estiver pronto
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', waitForElementor);
            } else {
                waitForElementor();
            }
            
        })();
        </script>
        <?php
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
        
        return true;
    }
} 