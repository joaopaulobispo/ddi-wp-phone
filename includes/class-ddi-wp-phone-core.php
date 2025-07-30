<?php
/**
 * Classe principal do plugin DDI WP Phone
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

// Prevenir acesso direto
if (!defined('ABSPATH')) {
    exit;
}

class DDI_WP_Phone_Core {
    
    /**
     * Construtor da classe
     */
    public function __construct() {
        $this->init_hooks();
    }
    
    /**
     * Inicializar hooks
     */
    private function init_hooks() {
        // Carregar apenas CSS e JS básico no frontend
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'), 999);
        
        // Inicializar apenas se necessário
        if (!is_admin()) {
            add_action('wp_footer', array($this, 'add_simple_script'), 999);
        }
    }
    
    /**
     * Carregar assets básicos
     */
    public function enqueue_assets() {
        // Apenas CSS básico
        wp_enqueue_style(
            'ddi-wp-phone-style',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/css/ddi-wp-phone-main.css',
            array(),
            DDI_WP_PHONE_VERSION
        );
    }
    
    /**
     * Adicionar script simples no footer
     */
    public function add_simple_script() {
        ?>
        <script>
        (function() {
            'use strict';
            
            // Aguardar DOM estar pronto
            function init() {
                // Processar após um delay para garantir que tudo carregou
                setTimeout(function() {
                    processPhoneFields();
                }, 1000);
                
                // Processar novamente após mais tempo para Elementor
                setTimeout(function() {
                    processPhoneFields();
                }, 3000);
            }
            
            function processPhoneFields() {
                try {
                    // Buscar campos de telefone de forma mais específica
                    var selectors = [
                        'input[type="tel"]',
                        '.elementor-field-type-tel input',
                        '.wpcf7-form-control[type="tel"]',
                        '#billing_phone',
                        '#shipping_phone'
                    ];
                    
                    var allInputs = [];
                    selectors.forEach(function(selector) {
                        var inputs = document.querySelectorAll(selector);
                        inputs.forEach(function(input) {
                            if (!allInputs.includes(input)) {
                                allInputs.push(input);
                            }
                        });
                    });
                    
                    console.log('DDI WP Phone: Encontrados', allInputs.length, 'campos de telefone');
                    
                    allInputs.forEach(function(input) {
                        if (!input.classList.contains('ddi-processed')) {
                            addPhoneSelector(input);
                        }
                    });
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao processar campos:', error);
                }
            }
            
            function addPhoneSelector(input) {
                try {
                    // Marcar como processado
                    input.classList.add('ddi-processed');
                    
                    // Criar container
                    var container = document.createElement('div');
                    container.className = 'ddi-phone-container';
                    container.style.cssText = 'position: relative !important; display: inline-block !important; width: 100% !important;';
                    
                    // Mover input para container
                    input.parentNode.insertBefore(container, input);
                    container.appendChild(input);
                    
                    // Criar seletor
                    var selector = document.createElement('div');
                    selector.className = 'ddi-phone-selector';
                    selector.innerHTML = '🇧🇷 +55';
                    selector.style.cssText = 'position: absolute !important; left: 0 !important; top: 0 !important; bottom: 0 !important; z-index: 10 !important; display: flex !important; align-items: center !important; background: #fff !important; border: 1px solid #ddd !important; border-right: none !important; border-radius: 4px 0 0 4px !important; cursor: pointer !important; min-width: 60px !important; padding: 0 8px !important; font-size: 14px !important; color: #333 !important; font-weight: 500 !important;';
                    
                    // Inserir seletor antes do input
                    container.insertBefore(selector, input);
                    
                    // Aplicar padding ao input
                    input.style.paddingLeft = '70px';
                    input.style.width = '100%';
                    input.style.boxSizing = 'border-box';
                    
                    console.log('DDI WP Phone: Seletor adicionado com sucesso');
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao adicionar seletor:', error);
                }
            }
            
            // Inicializar quando DOM estiver pronto
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
            
        })();
        </script>
        <?php
    }
} 