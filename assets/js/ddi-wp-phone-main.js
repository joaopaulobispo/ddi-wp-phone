/**
 * DDI WP Phone - JavaScript Principal
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

(function() {
    'use strict';
    
    // Verificar se jQuery está disponível
    if (typeof jQuery === 'undefined') {
        console.log('DDI WP Phone: jQuery não encontrado, usando JavaScript puro');
        return;
    }
    
    var $ = jQuery;
    
    // Namespace global
    window.DDIWpPhone = {
        
        // Configurações
        settings: {},
        
        /**
         * Inicialização
         */
        init: function() {
            console.log('DDI WP Phone: Inicializando...');
            
            // Verificar se ddiWpPhone está disponível
            if (typeof window.ddiWpPhone !== 'undefined' && window.ddiWpPhone.settings) {
                this.settings = window.ddiWpPhone.settings || {};
                console.log('DDI WP Phone: Configurações carregadas', this.settings);
            }
            
            // Aguardar o DOM estar pronto
            $(document).ready(function() {
                console.log('DDI WP Phone: DOM pronto, aguardando Elementor...');
                
                // Aguardar o Elementor carregar
                DDIWpPhone.waitForElementor();
            });
        },
        
        /**
         * Aguarda o Elementor carregar
         */
        waitForElementor: function() {
            if (typeof elementorFrontend !== 'undefined') {
                console.log('DDI WP Phone: Elementor já carregado, processando...');
                this.processForms();
            } else {
                console.log('DDI WP Phone: Aguardando Elementor carregar...');
                setTimeout(function() {
                    DDIWpPhone.waitForElementor();
                }, 500);
            }
        },
        
        /**
         * Processa formulários
         */
        processForms: function() {
            try {
                console.log('DDI WP Phone: Procurando campos de telefone...');
                
                // Procurar campos de telefone do Elementor
                var $elementorFields = $('.elementor-field-type-tel input[type="tel"]');
                console.log('DDI WP Phone: Campos Elementor encontrados:', $elementorFields.length);
                
                $elementorFields.each(function(index) {
                    console.log('DDI WP Phone: Processando campo Elementor', index);
                    DDIWpPhone.processField($(this));
                });
                
                // Procurar campos de telefone do CF7
                var $cf7Fields = $('.wpcf7-form-control[type="tel"]');
                console.log('DDI WP Phone: Campos CF7 encontrados:', $cf7Fields.length);
                
                $cf7Fields.each(function(index) {
                    console.log('DDI WP Phone: Processando campo CF7', index);
                    DDIWpPhone.processField($(this));
                });
                
                // Procurar campos de telefone do WooCommerce
                var $wooFields = $('#billing_phone, #shipping_phone, .woocommerce-address-fields input[type="tel"]');
                console.log('DDI WP Phone: Campos WooCommerce encontrados:', $wooFields.length);
                
                $wooFields.each(function(index) {
                    console.log('DDI WP Phone: Processando campo WooCommerce', index);
                    DDIWpPhone.processField($(this));
                });
                
            } catch (error) {
                console.error('DDI WP Phone: Erro ao processar formulários:', error);
            }
        },
        
        /**
         * Processa um campo individual
         */
        processField: function($input) {
            try {
                // Verificar se o campo já foi processado
                if ($input.hasClass('ddi-wp-phone-processed')) {
                    console.log('DDI WP Phone: Campo já processado, pulando...');
                    return;
                }
                
                // Verificar se o campo existe
                if (!$input.length) {
                    console.log('DDI WP Phone: Campo não encontrado');
                    return;
                }
                
                console.log('DDI WP Phone: Processando campo:', $input.attr('name') || $input.attr('id'));
                
                // Marcar como processado
                $input.addClass('ddi-wp-phone-processed');
                
                // Criar container
                var $container = $('<div class="ddi-wp-phone-container"></div>');
                
                // Envolver o input
                $input.wrap($container);
                
                // Criar seletor simples
                var $selector = $('<div class="ddi-wp-phone-selector">🇧🇷 +55</div>');
                
                // Inserir antes do input
                $input.before($selector);
                
                // Adicionar padding ao input
                $input.css('padding-left', '70px');
                
                console.log('DDI WP Phone: Campo processado com sucesso');
                
            } catch (error) {
                console.error('DDI WP Phone: Erro ao processar campo:', error);
            }
        }
    };
    
    // Inicializar quando o script for carregado
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            DDIWpPhone.init();
        });
    } else {
        DDIWpPhone.init();
    }
    
})(); 