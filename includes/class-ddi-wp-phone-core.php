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
                // Processar apenas após um delay para garantir que tudo carregou
                setTimeout(function() {
                    processPhoneFields();
                }, 2000);
            }
            
            function processPhoneFields() {
                try {
                    // Buscar campos de telefone de forma passiva
                    var phoneInputs = document.querySelectorAll('input[type="tel"]');
                    
                    phoneInputs.forEach(function(input) {
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
                    
                    // Adicionar classe para CSS
                    input.classList.add('ddi-phone-field');
                    
                    // Aplicar padding via CSS
                    input.style.paddingLeft = '70px';
                    
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