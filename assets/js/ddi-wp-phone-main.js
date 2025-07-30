/**
 * DDI WP Phone - JavaScript Principal
 * 
 * @package DDI_WP_Phone
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    // Namespace global
    window.DDIWpPhone = {
        
        // Configurações
        settings: {},
        countries: [],
        
        /**
         * Inicialização
         */
        init: function() {
            this.settings = window.ddiWpPhone ? window.ddiWpPhone.settings : {};
            this.loadCountries();
            this.bindEvents();
            
            // Processar campos existentes após um delay
            setTimeout(function() {
                DDIWpPhone.processAllForms();
            }, 1000);
        },
        
        /**
         * Carrega lista de países
         */
        loadCountries: function() {
            if (typeof libphonenumber !== 'undefined') {
                this.countries = libphonenumber.getCountries();
            } else {
                // Fallback se libphonenumber não estiver disponível
                this.countries = this.getFallbackCountries();
            }
        },
        
        /**
         * Lista de países fallback
         */
        getFallbackCountries: function() {
            return {
                'BR': { name: 'Brasil', code: '+55' },
                'US': { name: 'United States', code: '+1' },
                'CA': { name: 'Canada', code: '+1' },
                'MX': { name: 'México', code: '+52' },
                'AR': { name: 'Argentina', code: '+54' },
                'CL': { name: 'Chile', code: '+56' },
                'CO': { name: 'Colômbia', code: '+57' },
                'PE': { name: 'Peru', code: '+51' },
                'VE': { name: 'Venezuela', code: '+58' },
                'EC': { name: 'Ecuador', code: '+593' },
                'BO': { name: 'Bolivia', code: '+591' },
                'PY': { name: 'Paraguay', code: '+595' },
                'UY': { name: 'Uruguay', code: '+598' },
                'PT': { name: 'Portugal', code: '+351' },
                'ES': { name: 'Spain', code: '+34' },
                'FR': { name: 'France', code: '+33' },
                'DE': { name: 'Germany', code: '+49' },
                'IT': { name: 'Italy', code: '+39' },
                'GB': { name: 'United Kingdom', code: '+44' },
                'NL': { name: 'Netherlands', code: '+31' },
                'BE': { name: 'Belgium', code: '+32' },
                'CH': { name: 'Switzerland', code: '+41' },
                'AT': { name: 'Austria', code: '+43' },
                'SE': { name: 'Sweden', code: '+46' },
                'NO': { name: 'Norway', code: '+47' },
                'DK': { name: 'Denmark', code: '+45' },
                'FI': { name: 'Finland', code: '+358' },
                'PL': { name: 'Poland', code: '+48' },
                'CZ': { name: 'Czech Republic', code: '+420' },
                'HU': { name: 'Hungary', code: '+36' },
                'RO': { name: 'Romania', code: '+40' },
                'BG': { name: 'Bulgaria', code: '+359' },
                'HR': { name: 'Croatia', code: '+385' },
                'SI': { name: 'Slovenia', code: '+386' },
                'SK': { name: 'Slovakia', code: '+421' },
                'LT': { name: 'Lithuania', code: '+370' },
                'LV': { name: 'Latvia', code: '+371' },
                'EE': { name: 'Estonia', code: '+372' },
                'IE': { name: 'Ireland', code: '+353' },
                'LU': { name: 'Luxembourg', code: '+352' },
                'MT': { name: 'Malta', code: '+356' },
                'CY': { name: 'Cyprus', code: '+357' },
                'GR': { name: 'Greece', code: '+30' },
                'RU': { name: 'Russia', code: '+7' },
                'UA': { name: 'Ukraine', code: '+380' },
                'BY': { name: 'Belarus', code: '+375' },
                'MD': { name: 'Moldova', code: '+373' },
                'AM': { name: 'Armenia', code: '+374' },
                'AZ': { name: 'Azerbaijan', code: '+994' },
                'GE': { name: 'Georgia', code: '+995' },
                'KZ': { name: 'Kazakhstan', code: '+7' },
                'UZ': { name: 'Uzbekistan', code: '+998' },
                'KG': { name: 'Kyrgyzstan', code: '+996' },
                'TJ': { name: 'Tajikistan', code: '+992' },
                'TM': { name: 'Turkmenistan', code: '+993' },
                'AF': { name: 'Afghanistan', code: '+93' },
                'PK': { name: 'Pakistan', code: '+92' },
                'IN': { name: 'India', code: '+91' },
                'BD': { name: 'Bangladesh', code: '+880' },
                'LK': { name: 'Sri Lanka', code: '+94' },
                'NP': { name: 'Nepal', code: '+977' },
                'BT': { name: 'Bhutan', code: '+975' },
                'MV': { name: 'Maldives', code: '+960' },
                'MM': { name: 'Myanmar', code: '+95' },
                'TH': { name: 'Thailand', code: '+66' },
                'LA': { name: 'Laos', code: '+856' },
                'KH': { name: 'Cambodia', code: '+855' },
                'VN': { name: 'Vietnam', code: '+84' },
                'MY': { name: 'Malaysia', code: '+60' },
                'SG': { name: 'Singapore', code: '+65' },
                'ID': { name: 'Indonesia', code: '+62' },
                'PH': { name: 'Philippines', code: '+63' },
                'BN': { name: 'Brunei', code: '+673' },
                'TL': { name: 'East Timor', code: '+670' },
                'PG': { name: 'Papua New Guinea', code: '+675' },
                'FJ': { name: 'Fiji', code: '+679' },
                'NC': { name: 'New Caledonia', code: '+687' },
                'VU': { name: 'Vanuatu', code: '+678' },
                'SB': { name: 'Solomon Islands', code: '+677' },
                'TO': { name: 'Tonga', code: '+676' },
                'WS': { name: 'Samoa', code: '+685' },
                'KI': { name: 'Kiribati', code: '+686' },
                'TV': { name: 'Tuvalu', code: '+688' },
                'NR': { name: 'Nauru', code: '+674' },
                'PW': { name: 'Palau', code: '+680' },
                'FM': { name: 'Micronesia', code: '+691' },
                'MH': { name: 'Marshall Islands', code: '+692' },
                'CK': { name: 'Cook Islands', code: '+682' },
                'NU': { name: 'Niue', code: '+683' },
                'TK': { name: 'Tokelau', code: '+690' },
                'AS': { name: 'American Samoa', code: '+1' },
                'GU': { name: 'Guam', code: '+1' },
                'MP': { name: 'Northern Mariana Islands', code: '+1' },
                'PR': { name: 'Puerto Rico', code: '+1' },
                'VI': { name: 'U.S. Virgin Islands', code: '+1' },
                'AI': { name: 'Anguilla', code: '+1' },
                'AG': { name: 'Antigua and Barbuda', code: '+1' },
                'AW': { name: 'Aruba', code: '+297' },
                'BS': { name: 'Bahamas', code: '+1' },
                'BB': { name: 'Barbados', code: '+1' },
                'BZ': { name: 'Belize', code: '+501' },
                'BM': { name: 'Bermuda', code: '+1' },
                'VG': { name: 'British Virgin Islands', code: '+1' },
                'KY': { name: 'Cayman Islands', code: '+1' },
                'CR': { name: 'Costa Rica', code: '+506' },
                'CU': { name: 'Cuba', code: '+53' },
                'DM': { name: 'Dominica', code: '+1' },
                'DO': { name: 'Dominican Republic', code: '+1' },
                'SV': { name: 'El Salvador', code: '+503' },
                'GD': { name: 'Grenada', code: '+1' },
                'GT': { name: 'Guatemala', code: '+502' },
                'HT': { name: 'Haiti', code: '+509' },
                'HN': { name: 'Honduras', code: '+504' },
                'JM': { name: 'Jamaica', code: '+1' },
                'NI': { name: 'Nicaragua', code: '+505' },
                'PA': { name: 'Panama', code: '+507' },
                'KN': { name: 'Saint Kitts and Nevis', code: '+1' },
                'LC': { name: 'Saint Lucia', code: '+1' },
                'VC': { name: 'Saint Vincent and the Grenadines', code: '+1' },
                'TT': { name: 'Trinidad and Tobago', code: '+1' },
                'TC': { name: 'Turks and Caicos Islands', code: '+1' },
                'AU': { name: 'Australia', code: '+61' },
                'NZ': { name: 'New Zealand', code: '+64' },
                'CN': { name: 'China', code: '+86' },
                'JP': { name: 'Japan', code: '+81' },
                'KR': { name: 'South Korea', code: '+82' },
                'TW': { name: 'Taiwan', code: '+886' },
                'HK': { name: 'Hong Kong', code: '+852' },
                'MO': { name: 'Macau', code: '+853' },
                'MN': { name: 'Mongolia', code: '+976' },
                'KP': { name: 'North Korea', code: '+850' },
                'IL': { name: 'Israel', code: '+972' },
                'JO': { name: 'Jordan', code: '+962' },
                'LB': { name: 'Lebanon', code: '+961' },
                'SY': { name: 'Syria', code: '+963' },
                'IQ': { name: 'Iraq', code: '+964' },
                'KW': { name: 'Kuwait', code: '+965' },
                'SA': { name: 'Saudi Arabia', code: '+966' },
                'AE': { name: 'United Arab Emirates', code: '+971' },
                'QA': { name: 'Qatar', code: '+974' },
                'BH': { name: 'Bahrain', code: '+973' },
                'OM': { name: 'Oman', code: '+968' },
                'YE': { name: 'Yemen', code: '+967' },
                'EG': { name: 'Egypt', code: '+20' },
                'LY': { name: 'Libya', code: '+218' },
                'TN': { name: 'Tunisia', code: '+216' },
                'DZ': { name: 'Algeria', code: '+213' },
                'MA': { name: 'Morocco', code: '+212' },
                'EH': { name: 'Western Sahara', code: '+212' },
                'MR': { name: 'Mauritania', code: '+222' },
                'ML': { name: 'Mali', code: '+223' },
                'BF': { name: 'Burkina Faso', code: '+226' },
                'NE': { name: 'Niger', code: '+227' },
                'TD': { name: 'Chad', code: '+235' },
                'SD': { name: 'Sudan', code: '+249' },
                'ER': { name: 'Eritrea', code: '+291' },
                'DJ': { name: 'Djibouti', code: '+253' },
                'SO': { name: 'Somalia', code: '+252' },
                'ET': { name: 'Ethiopia', code: '+251' },
                'KE': { name: 'Kenya', code: '+254' },
                'TZ': { name: 'Tanzania', code: '+255' },
                'UG': { name: 'Uganda', code: '+256' },
                'BI': { name: 'Burundi', code: '+257' },
                'RW': { name: 'Rwanda', code: '+250' },
                'CD': { name: 'Democratic Republic of the Congo', code: '+243' },
                'CG': { name: 'Republic of the Congo', code: '+242' },
                'CF': { name: 'Central African Republic', code: '+236' },
                'CM': { name: 'Cameroon', code: '+237' },
                'GQ': { name: 'Equatorial Guinea', code: '+240' },
                'GA': { name: 'Gabon', code: '+241' },
                'ST': { name: 'São Tomé and Príncipe', code: '+239' },
                'AO': { name: 'Angola', code: '+244' },
                'ZM': { name: 'Zambia', code: '+260' },
                'ZW': { name: 'Zimbabwe', code: '+263' },
                'MW': { name: 'Malawi', code: '+265' },
                'MZ': { name: 'Mozambique', code: '+258' },
                'SZ': { name: 'Eswatini', code: '+268' },
                'LS': { name: 'Lesotho', code: '+266' },
                'BW': { name: 'Botswana', code: '+267' },
                'NA': { name: 'Namibia', code: '+264' },
                'ZA': { name: 'South Africa', code: '+27' },
                'MG': { name: 'Madagascar', code: '+261' },
                'MU': { name: 'Mauritius', code: '+230' },
                'SC': { name: 'Seychelles', code: '+248' },
                'KM': { name: 'Comoros', code: '+269' },
                'YT': { name: 'Mayotte', code: '+262' },
                'RE': { name: 'Réunion', code: '+262' },
                'IO': { name: 'British Indian Ocean Territory', code: '+246' },
                'SH': { name: 'Saint Helena', code: '+290' },
                'AC': { name: 'Ascension Island', code: '+247' },
                'TA': { name: 'Tristan da Cunha', code: '+290' },
                'GS': { name: 'South Georgia and the South Sandwich Islands', code: '+500' },
                'FK': { name: 'Falkland Islands', code: '+500' },
                'BV': { name: 'Bouvet Island', code: '+47' },
                'AQ': { name: 'Antarctica', code: '+672' },
                'TF': { name: 'French Southern Territories', code: '+262' },
                'HM': { name: 'Heard Island and McDonald Islands', code: '+672' },
                'CC': { name: 'Cocos Islands', code: '+61' },
                'CX': { name: 'Christmas Island', code: '+61' },
                'NF': { name: 'Norfolk Island', code: '+672' },
                'PN': { name: 'Pitcairn Islands', code: '+64' },
                'WF': { name: 'Wallis and Futuna', code: '+681' },
                'PF': { name: 'French Polynesia', code: '+689' }
            };
        },
        
        /**
         * Bind de eventos
         */
        bindEvents: function() {
            $(document).on('click', '.ddi-wp-phone-selector', this.toggleDropdown);
            $(document).on('click', '.ddi-wp-phone-item', this.selectCountry);
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.ddi-wp-phone-container').length) {
                    $('.ddi-wp-phone-dropdown').removeClass('show');
                }
            });
        },
        
        /**
         * Processa todos os formulários
         */
        processAllForms: function() {
            try {
                this.processElementorForms();
                this.processCF7Forms();
                this.processWooCommerceForms();
            } catch (error) {
                console.log('DDI WP Phone: Erro ao processar formulários:', error);
            }
        },
        
        /**
         * Processa formulários do Elementor
         */
        processElementorForms: function() {
            try {
                $('.elementor-field-type-tel input[type="tel"]').each(function() {
                    DDIWpPhone.processPhoneField($(this));
                });
            } catch (error) {
                console.log('DDI WP Phone: Erro ao processar Elementor:', error);
            }
        },
        
        /**
         * Processa formulários do Contact Form 7
         */
        processCF7Forms: function() {
            try {
                $('.wpcf7-form-control[type="tel"]').each(function() {
                    DDIWpPhone.processPhoneField($(this));
                });
            } catch (error) {
                console.log('DDI WP Phone: Erro ao processar CF7:', error);
            }
        },
        
        /**
         * Processa formulários do WooCommerce
         */
        processWooCommerceForms: function() {
            try {
                $('#billing_phone, #shipping_phone, .woocommerce-address-fields input[type="tel"]').each(function() {
                    DDIWpPhone.processPhoneField($(this));
                });
            } catch (error) {
                console.log('DDI WP Phone: Erro ao processar WooCommerce:', error);
            }
        },
        
        /**
         * Processa um campo de telefone
         */
        processPhoneField: function($input) {
            try {
                if (!$input || !$input.length) {
                    return;
                }
                
                if ($input.closest('.ddi-wp-phone-container').length) {
                    return; // Já foi processado
                }
                
                var $container = $('<div class="ddi-wp-phone-container"></div>');
                var $selector = this.createCountrySelector();
                
                $input.wrap($container);
                $input.before($selector);
                
                // Aplicar país padrão
                this.applyDefaultCountry($input);
            } catch (error) {
                console.log('DDI WP Phone: Erro ao processar campo:', error);
            }
        },
        
        /**
         * Cria o seletor de país
         */
        createCountrySelector: function() {
            try {
                var $selector = $('<div class="ddi-wp-phone-selector"></div>');
                var $flag = $('<div class="ddi-wp-phone-flag"></div>');
                var $dropdown = $('<div class="ddi-wp-phone-dropdown"></div>');
                
                $selector.append($flag);
                $selector.append($dropdown);
                
                // Popular dropdown
                this.populateDropdown($dropdown);
                
                return $selector;
            } catch (error) {
                console.log('DDI WP Phone: Erro ao criar seletor:', error);
                return $('<div></div>');
            }
        },
        
        /**
         * Popula o dropdown com países
         */
        populateDropdown: function($dropdown) {
            try {
                var self = this;
                
                $.each(this.countries, function(countryCode, countryData) {
                    var countryName = typeof countryData === 'object' ? countryData.name : countryCode;
                    var countryCodeValue = typeof countryData === 'object' ? countryData.code : '+1';
                    
                    var $item = $('<div class="ddi-wp-phone-item" data-country="' + countryCode + '"></div>');
                    var $flag = $('<img class="flag" src="' + self.getFlagUrl(countryCode) + '" alt="' + countryName + '">');
                    var $name = $('<span class="country-name">' + countryName + '</span>');
                    var $code = $('<span class="country-code">' + countryCodeValue + '</span>');
                    
                    $item.append($flag).append($name).append($code);
                    $dropdown.append($item);
                });
            } catch (error) {
                console.log('DDI WP Phone: Erro ao popular dropdown:', error);
            }
        },
        
        /**
         * Obtém URL da bandeira
         */
        getFlagUrl: function(countryCode) {
            try {
                var pluginUrl = window.ddiWpPhone ? window.ddiWpPhone.plugin_url : '';
                return pluginUrl + 'assets/vendor/flag-icons/flags/4x3/' + countryCode.toLowerCase() + '.svg';
            } catch (error) {
                console.log('DDI WP Phone: Erro ao obter URL da bandeira:', error);
                return '';
            }
        },
        
        /**
         * Aplica país padrão
         */
        applyDefaultCountry: function($input) {
            try {
                var defaultCountry = this.settings.default_country || 'BR';
                var $container = $input.closest('.ddi-wp-phone-container');
                var $selector = $container.find('.ddi-wp-phone-selector');
                
                this.updateFlag($selector, defaultCountry);
                this.applyPhoneMask($input, defaultCountry);
            } catch (error) {
                console.log('DDI WP Phone: Erro ao aplicar país padrão:', error);
            }
        },
        
        /**
         * Toggle do dropdown
         */
        toggleDropdown: function(e) {
            try {
                e.preventDefault();
                var $dropdown = $(this).find('.ddi-wp-phone-dropdown');
                $('.ddi-wp-phone-dropdown').not($dropdown).removeClass('show');
                $dropdown.toggleClass('show');
            } catch (error) {
                console.log('DDI WP Phone: Erro no toggle dropdown:', error);
            }
        },
        
        /**
         * Seleciona país
         */
        selectCountry: function(e) {
            try {
                e.preventDefault();
                var countryCode = $(this).data('country');
                var $container = $(this).closest('.ddi-wp-phone-container');
                var $selector = $container.find('.ddi-wp-phone-selector');
                var $input = $container.find('input[type="tel"]');
                
                DDIWpPhone.updateFlag($selector, countryCode);
                DDIWpPhone.applyPhoneMask($input, countryCode);
                $container.find('.ddi-wp-phone-dropdown').removeClass('show');
            } catch (error) {
                console.log('DDI WP Phone: Erro ao selecionar país:', error);
            }
        },
        
        /**
         * Atualiza bandeira
         */
        updateFlag: function($selector, countryCode) {
            try {
                var countryData = this.countries[countryCode];
                var countryName = typeof countryData === 'object' ? countryData.name : countryCode;
                var countryCodeValue = typeof countryData === 'object' ? countryData.code : '+1';
                
                var $flag = $selector.find('.ddi-wp-phone-flag');
                $flag.html('<img src="' + this.getFlagUrl(countryCode) + '" alt="' + countryName + '">');
                
                if (this.settings.show_ddi_code) {
                    $flag.append('<span class="ddi-code">' + countryCodeValue + '</span>');
                }
            } catch (error) {
                console.log('DDI WP Phone: Erro ao atualizar bandeira:', error);
            }
        },
        
        /**
         * Aplica máscara de telefone
         */
        applyPhoneMask: function($input, countryCode) {
            try {
                if (typeof libphonenumber !== 'undefined') {
                    // Usar libphonenumber para máscara
                    var phoneUtil = libphonenumber.PhoneNumberUtil.getInstance();
                    var countryMetadata = phoneUtil.getMetadataForRegion(countryCode);
                    
                    if (countryMetadata) {
                        // Aplicar máscara baseada no metadata
                        this.applyAdvancedMask($input, countryCode);
                    } else {
                        // Máscara simples
                        this.applySimpleMask($input, countryCode);
                    }
                } else {
                    // Máscara simples como fallback
                    this.applySimpleMask($input, countryCode);
                }
            } catch (error) {
                console.log('DDI WP Phone: Erro ao aplicar máscara:', error);
                this.applySimpleMask($input, countryCode);
            }
        },
        
        /**
         * Aplica máscara avançada
         */
        applyAdvancedMask: function($input, countryCode) {
            // Implementação avançada com libphonenumber
            // Por enquanto, usar máscara simples
            this.applySimpleMask($input, countryCode);
        },
        
        /**
         * Aplica máscara simples
         */
        applySimpleMask: function($input, countryCode) {
            try {
                // Máscaras básicas por país
                var masks = {
                    'BR': '(00) 00000-0000',
                    'US': '(000) 000-0000',
                    'CA': '(000) 000-0000',
                    'MX': '000 000 0000',
                    'AR': '000 000-0000',
                    'CL': '0000 0000',
                    'CO': '000 000 0000',
                    'PE': '000 000 000',
                    'VE': '000-000-0000',
                    'EC': '000 000 0000',
                    'BO': '000 000 000',
                    'PY': '000 000 000',
                    'UY': '000 000 000',
                    'PT': '000 000 000',
                    'ES': '000 000 000',
                    'FR': '00 00 00 00 00',
                    'DE': '0000 000000',
                    'IT': '000 000 0000',
                    'GB': '0000 000000',
                    'NL': '00 00000000',
                    'BE': '000 000 000',
                    'CH': '000 000 0000',
                    'AT': '0000 000000',
                    'SE': '000 000 0000',
                    'NO': '000 00 000',
                    'DK': '00 00 00 00',
                    'FI': '000 000 0000',
                    'PL': '000 000 000',
                    'CZ': '000 000 000',
                    'HU': '00 000 0000',
                    'RO': '000 000 000',
                    'BG': '000 000 000',
                    'HR': '000 000 000',
                    'SI': '000 000 000',
                    'SK': '000 000 000',
                    'LT': '000 00000',
                    'LV': '000 00000',
                    'EE': '000 00000',
                    'IE': '000 000 0000',
                    'LU': '000 000 000',
                    'MT': '0000 0000',
                    'CY': '00 000000',
                    'GR': '000 000 0000',
                    'RU': '000 000-00-00',
                    'UA': '000 000 0000',
                    'BY': '000 000 0000',
                    'MD': '000 000 000',
                    'AM': '000 000 000',
                    'AZ': '000 000 0000',
                    'GE': '000 000 000',
                    'KZ': '000 000 0000',
                    'UZ': '000 000 0000',
                    'KG': '000 000 000',
                    'TJ': '000 000 000',
                    'TM': '000 000 000',
                    'AF': '000 000 0000',
                    'PK': '000 000 0000',
                    'IN': '00000 00000',
                    'BD': '00000 000000',
                    'LK': '000 000 0000',
                    'NP': '000 000 0000',
                    'BT': '000 000 000',
                    'MV': '000 0000',
                    'MM': '000 000 0000',
                    'TH': '000 000 0000',
                    'LA': '000 000 000',
                    'KH': '000 000 000',
                    'VN': '000 000 0000',
                    'MY': '000 000 0000',
                    'SG': '0000 0000',
                    'ID': '000 000 000',
                    'PH': '000 000 0000',
                    'BN': '000 000 000',
                    'TL': '000 000 000',
                    'PG': '000 000 000',
                    'FJ': '000 0000',
                    'NC': '000 000',
                    'VU': '000 0000',
                    'SB': '000 0000',
                    'TO': '000 0000',
                    'WS': '000 0000',
                    'KI': '000 0000',
                    'TV': '000 0000',
                    'NR': '000 0000',
                    'PW': '000 0000',
                    'FM': '000 0000',
                    'MH': '000 0000',
                    'CK': '000 0000',
                    'NU': '000 0000',
                    'TK': '000 0000',
                    'AS': '(000) 000-0000',
                    'GU': '(000) 000-0000',
                    'MP': '(000) 000-0000',
                    'PR': '(000) 000-0000',
                    'VI': '(000) 000-0000',
                    'AI': '(000) 000-0000',
                    'AG': '(000) 000-0000',
                    'AW': '000 0000',
                    'BS': '(000) 000-0000',
                    'BB': '(000) 000-0000',
                    'BZ': '000 0000',
                    'BM': '(000) 000-0000',
                    'VG': '(000) 000-0000',
                    'KY': '(000) 000-0000',
                    'CR': '0000 0000',
                    'CU': '000 000 0000',
                    'DM': '(000) 000-0000',
                    'DO': '(000) 000-0000',
                    'SV': '0000 0000',
                    'GD': '(000) 000-0000',
                    'GT': '0000 0000',
                    'HT': '0000 0000',
                    'HN': '0000 0000',
                    'JM': '(000) 000-0000',
                    'NI': '0000 0000',
                    'PA': '0000 0000',
                    'KN': '(000) 000-0000',
                    'LC': '(000) 000-0000',
                    'VC': '(000) 000-0000',
                    'TT': '(000) 000-0000',
                    'TC': '(000) 000-0000',
                    'AU': '0000 000 000',
                    'NZ': '000 000 0000',
                    'CN': '000 0000 0000',
                    'JP': '000 0000 0000',
                    'KR': '000 0000 0000',
                    'TW': '0000 000 000',
                    'HK': '0000 0000',
                    'MO': '0000 0000',
                    'MN': '0000 0000',
                    'KP': '000 0000 0000',
                    'IL': '000 000 0000',
                    'JO': '000 000 0000',
                    'LB': '000 000 000',
                    'SY': '000 000 0000',
                    'IQ': '000 000 0000',
                    'KW': '000 00000',
                    'SA': '000 000 0000',
                    'AE': '000 000 0000',
                    'QA': '0000 0000',
                    'BH': '0000 0000',
                    'OM': '0000 0000',
                    'YE': '000 000 0000',
                    'EG': '000 000 0000',
                    'LY': '000 000 0000',
                    'TN': '000 000 000',
                    'DZ': '000 000 0000',
                    'MA': '000 000 0000',
                    'EH': '000 000 0000',
                    'MR': '000 000 0000',
                    'ML': '000 000 0000',
                    'BF': '000 000 0000',
                    'NE': '000 000 0000',
                    'TD': '000 000 0000',
                    'SD': '000 000 0000',
                    'ER': '000 000 0000',
                    'DJ': '000 000 0000',
                    'SO': '000 000 0000',
                    'ET': '000 000 0000',
                    'KE': '000 000 0000',
                    'TZ': '000 000 0000',
                    'UG': '000 000 0000',
                    'BI': '000 000 0000',
                    'RW': '000 000 0000',
                    'CD': '000 000 0000',
                    'CG': '000 000 0000',
                    'CF': '000 000 0000',
                    'CM': '000 000 0000',
                    'GQ': '000 000 0000',
                    'GA': '000 000 0000',
                    'ST': '000 000 0000',
                    'AO': '000 000 0000',
                    'ZM': '000 000 0000',
                    'ZW': '000 000 0000',
                    'MW': '000 000 0000',
                    'MZ': '000 000 0000',
                    'SZ': '000 000 0000',
                    'LS': '000 000 0000',
                    'BW': '000 000 0000',
                    'NA': '000 000 0000',
                    'ZA': '000 000 0000',
                    'MG': '000 000 0000',
                    'MU': '000 000 0000',
                    'SC': '000 000 0000',
                    'KM': '000 000 0000',
                    'YT': '000 000 0000',
                    'RE': '000 000 0000',
                    'IO': '000 000 0000',
                    'SH': '000 000 0000',
                    'AC': '000 000 0000',
                    'TA': '000 000 0000',
                    'GS': '000 000 0000',
                    'FK': '000 000 0000',
                    'BV': '000 000 0000',
                    'AQ': '000 000 0000',
                    'TF': '000 000 0000',
                    'HM': '000 000 0000',
                    'CC': '000 000 0000',
                    'CX': '000 000 0000',
                    'NF': '000 000 0000',
                    'PN': '000 000 0000',
                    'WF': '000 000 0000',
                    'PF': '000 000 0000'
                };
                
                var mask = masks[countryCode] || '000 000 0000';
                
                // Aplicar máscara usando jQuery Mask Plugin ou implementação própria
                if ($.fn.mask) {
                    $input.mask(mask);
                } else {
                    // Implementação simples de máscara
                    this.applySimpleMaskImplementation($input, mask);
                }
            } catch (error) {
                console.log('DDI WP Phone: Erro ao aplicar máscara simples:', error);
            }
        },
        
        /**
         * Implementação simples de máscara
         */
        applySimpleMaskImplementation: function($input, mask) {
            try {
                $input.off('input.ddi-wp-phone-mask').on('input.ddi-wp-phone-mask', function() {
                    var value = $(this).val().replace(/\D/g, '');
                    var maskedValue = '';
                    var valueIndex = 0;
                    
                    for (var i = 0; i < mask.length && valueIndex < value.length; i++) {
                        if (mask[i] === '0') {
                            maskedValue += value[valueIndex];
                            valueIndex++;
                        } else {
                            maskedValue += mask[i];
                        }
                    }
                    
                    $(this).val(maskedValue);
                });
            } catch (error) {
                console.log('DDI WP Phone: Erro na implementação de máscara:', error);
            }
        }
    };
    
    // Inicializar quando documento estiver pronto
    $(document).ready(function() {
        DDIWpPhone.init();
    });
    
})(jQuery); 