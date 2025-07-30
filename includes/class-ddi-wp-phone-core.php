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
            add_action('wp_footer', array($this, 'add_complete_script'), 999);
        }
    }
    
    /**
     * Carregar assets básicos
     */
    public function enqueue_assets() {
        // CSS principal
        wp_enqueue_style(
            'ddi-wp-phone-style',
            DDI_WP_PHONE_PLUGIN_URL . 'assets/css/ddi-wp-phone-main.css',
            array(),
            DDI_WP_PHONE_VERSION
        );
    }
    
    /**
     * Adicionar script completo no footer
     */
    public function add_complete_script() {
        ?>
        <script>
        (function() {
            'use strict';
            
            // Dados dos países
            var countries = [
                { code: 'BR', name: 'Brasil', ddi: '+55', flag: '🇧🇷', mask: '(00) 00000-0000' },
                { code: 'US', name: 'Estados Unidos', ddi: '+1', flag: '🇺🇸', mask: '(000) 000-0000' },
                { code: 'AR', name: 'Argentina', ddi: '+54', flag: '🇦🇷', mask: '(00) 0000-0000' },
                { code: 'CL', name: 'Chile', ddi: '+56', flag: '🇨🇱', mask: '(00) 0000-0000' },
                { code: 'CO', name: 'Colômbia', ddi: '+57', flag: '🇨🇴', mask: '(000) 000-0000' },
                { code: 'MX', name: 'México', ddi: '+52', flag: '🇲🇽', mask: '(000) 000-0000' },
                { code: 'PE', name: 'Peru', ddi: '+51', flag: '🇵🇪', mask: '(000) 000-0000' },
                { code: 'UY', name: 'Uruguai', ddi: '+598', flag: '🇺🇾', mask: '000 000 000' },
                { code: 'PY', name: 'Paraguai', ddi: '+595', flag: '🇵🇾', mask: '(000) 000-000' },
                { code: 'BO', name: 'Bolívia', ddi: '+591', flag: '🇧🇴', mask: '(000) 000-000' }
            ];
            
            var currentCountry = countries[0]; // Brasil como padrão
            var activeDropdown = null;
            
            // Aguardar DOM estar pronto
            function init() {
                // Processar após carregamento inicial
                setTimeout(function() {
                    processPhoneFields();
                }, 1000);
                
                // Processar novamente para Elementor
                setTimeout(function() {
                    processPhoneFields();
                }, 3000);
                
                // Processar para popups do Elementor
                setTimeout(function() {
                    processPhoneFields();
                }, 5000);
                
                // Observar mudanças no DOM para popups
                observeDOM();
            }
            
            function observeDOM() {
                // Observer para detectar novos elementos
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList') {
                            setTimeout(function() {
                                processPhoneFields();
                            }, 500);
                        }
                    });
                });
                
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
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
                    
                    // Mover input para container
                    input.parentNode.insertBefore(container, input);
                    container.appendChild(input);
                    
                    // Criar seletor
                    var selector = document.createElement('div');
                    selector.className = 'ddi-phone-selector';
                    selector.innerHTML = currentCountry.flag + ' ' + currentCountry.ddi;
                    selector.addEventListener('click', function(e) {
                        e.preventDefault();
                        toggleDropdown(container, selector);
                    });
                    
                    // Inserir seletor antes do input
                    container.insertBefore(selector, input);
                    
                    // Aplicar máscara inicial
                    applyMask(input, currentCountry.mask);
                    
                    console.log('DDI WP Phone: Seletor adicionado com sucesso');
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao adicionar seletor:', error);
                }
            }
            
            function toggleDropdown(container, selector) {
                // Fechar dropdown ativo se existir
                if (activeDropdown) {
                    activeDropdown.remove();
                    activeDropdown = null;
                }
                
                // Criar dropdown
                var dropdown = document.createElement('div');
                dropdown.className = 'ddi-phone-dropdown';
                
                countries.forEach(function(country) {
                    var item = document.createElement('div');
                    item.className = 'ddi-phone-item';
                    item.innerHTML = country.flag + ' ' + country.name + ' ' + country.ddi;
                    item.addEventListener('click', function() {
                        selectCountry(country, container, selector);
                        dropdown.remove();
                        activeDropdown = null;
                    });
                    dropdown.appendChild(item);
                });
                
                container.appendChild(dropdown);
                activeDropdown = dropdown;
                
                // Fechar dropdown ao clicar fora
                setTimeout(function() {
                    document.addEventListener('click', function closeDropdown(e) {
                        if (!container.contains(e.target)) {
                            dropdown.remove();
                            activeDropdown = null;
                            document.removeEventListener('click', closeDropdown);
                        }
                    });
                }, 100);
            }
            
            function selectCountry(country, container, selector) {
                currentCountry = country;
                selector.innerHTML = country.flag + ' ' + country.ddi;
                
                var input = container.querySelector('input');
                if (input) {
                    applyMask(input, country.mask);
                }
            }
            
            function applyMask(input, mask) {
                input.addEventListener('input', function(e) {
                    var value = e.target.value.replace(/\D/g, '');
                    var maskedValue = '';
                    var maskIndex = 0;
                    
                    for (var i = 0; i < value.length && maskIndex < mask.length; i++) {
                        if (mask[maskIndex] === '0') {
                            maskedValue += value[i];
                            maskIndex++;
                        } else {
                            maskedValue += mask[maskIndex];
                            maskIndex++;
                            i--; // Não avança no valor
                        }
                    }
                    
                    e.target.value = maskedValue;
                });
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