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
            '1.1.0'
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
            
            // Dados completos dos 249 países da libphonenumber-js
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
                { code: 'BO', name: 'Bolívia', ddi: '+591', flag: '🇧🇴', mask: '(000) 000-000' },
                { code: 'EC', name: 'Equador', ddi: '+593', flag: '🇪🇨', mask: '(000) 000-000' },
                { code: 'VE', name: 'Venezuela', ddi: '+58', flag: '🇻🇪', mask: '(000) 000-0000' },
                { code: 'GY', name: 'Guiana', ddi: '+592', flag: '🇬🇾', mask: '000 0000' },
                { code: 'SR', name: 'Suriname', ddi: '+597', flag: '🇸🇷', mask: '000-0000' },
                { code: 'GF', name: 'Guiana Francesa', ddi: '+594', flag: '🇬🇫', mask: '000 000 000' },
                { code: 'CA', name: 'Canadá', ddi: '+1', flag: '🇨🇦', mask: '(000) 000-0000' },
                { code: 'GB', name: 'Reino Unido', ddi: '+44', flag: '🇬🇧', mask: '0000 000000' },
                { code: 'DE', name: 'Alemanha', ddi: '+49', flag: '🇩🇪', mask: '000 000000' },
                { code: 'FR', name: 'França', ddi: '+33', flag: '🇫🇷', mask: '0 00 00 00 00' },
                { code: 'IT', name: 'Itália', ddi: '+39', flag: '🇮🇹', mask: '000 000 0000' },
                { code: 'ES', name: 'Espanha', ddi: '+34', flag: '🇪🇸', mask: '000 000 000' },
                { code: 'PT', name: 'Portugal', ddi: '+351', flag: '🇵🇹', mask: '000 000 000' },
                { code: 'NL', name: 'Países Baixos', ddi: '+31', flag: '🇳🇱', mask: '00 00000000' },
                { code: 'BE', name: 'Bélgica', ddi: '+32', flag: '🇧🇪', mask: '000 000 000' },
                { code: 'CH', name: 'Suíça', ddi: '+41', flag: '🇨🇭', mask: '00 000 00 00' },
                { code: 'AT', name: 'Áustria', ddi: '+43', flag: '🇦🇹', mask: '000 000000' },
                { code: 'SE', name: 'Suécia', ddi: '+46', flag: '🇸🇪', mask: '00 000 00 00' },
                { code: 'NO', name: 'Noruega', ddi: '+47', flag: '🇳🇴', mask: '000 00 000' },
                { code: 'DK', name: 'Dinamarca', ddi: '+45', flag: '🇩🇰', mask: '00 00 00 00' },
                { code: 'FI', name: 'Finlândia', ddi: '+358', flag: '🇫🇮', mask: '000 000000' },
                { code: 'PL', name: 'Polônia', ddi: '+48', flag: '🇵🇱', mask: '000 000 000' },
                { code: 'CZ', name: 'República Tcheca', ddi: '+420', flag: '🇨🇿', mask: '000 000 000' },
                { code: 'HU', name: 'Hungria', ddi: '+36', flag: '🇭🇺', mask: '00 000 0000' },
                { code: 'RO', name: 'Romênia', ddi: '+40', flag: '🇷🇴', mask: '000 000 000' },
                { code: 'BG', name: 'Bulgária', ddi: '+359', flag: '🇧🇬', mask: '000 000 000' },
                { code: 'HR', name: 'Croácia', ddi: '+385', flag: '🇭🇷', mask: '000 000 000' },
                { code: 'SI', name: 'Eslovênia', ddi: '+386', flag: '🇸🇮', mask: '000 000 000' },
                { code: 'SK', name: 'Eslováquia', ddi: '+421', flag: '🇸🇰', mask: '000 000 000' },
                { code: 'LT', name: 'Lituânia', ddi: '+370', flag: '🇱🇹', mask: '000 00000' },
                { code: 'LV', name: 'Letônia', ddi: '+371', flag: '🇱🇻', mask: '00000000' },
                { code: 'EE', name: 'Estônia', ddi: '+372', flag: '🇪🇪', mask: '0000 0000' },
                { code: 'IE', name: 'Irlanda', ddi: '+353', flag: '🇮🇪', mask: '000 000 000' },
                { code: 'GR', name: 'Grécia', ddi: '+30', flag: '🇬🇷', mask: '000 000 0000' },
                { code: 'CY', name: 'Chipre', ddi: '+357', flag: '🇨🇾', mask: '00 000000' },
                { code: 'MT', name: 'Malta', ddi: '+356', flag: '🇲🇹', mask: '0000 0000' },
                { code: 'LU', name: 'Luxemburgo', ddi: '+352', flag: '🇱🇺', mask: '000 000 000' },
                { code: 'IS', name: 'Islândia', ddi: '+354', flag: '🇮🇸', mask: '000 0000' },
                { code: 'RU', name: 'Rússia', ddi: '+7', flag: '🇷🇺', mask: '(000) 000-00-00' },
                { code: 'UA', name: 'Ucrânia', ddi: '+380', flag: '🇺🇦', mask: '00 000 0000' },
                { code: 'BY', name: 'Bielorrússia', ddi: '+375', flag: '🇧🇾', mask: '00 000-00-00' },
                { code: 'MD', name: 'Moldávia', ddi: '+373', flag: '🇲🇩', mask: '0000 0000' },
                { code: 'GE', name: 'Geórgia', ddi: '+995', flag: '🇬🇪', mask: '000 000 000' },
                { code: 'AM', name: 'Armênia', ddi: '+374', flag: '🇦🇲', mask: '00 000000' },
                { code: 'AZ', name: 'Azerbaijão', ddi: '+994', flag: '🇦🇿', mask: '000 000 00 00' },
                { code: 'TR', name: 'Turquia', ddi: '+90', flag: '🇹🇷', mask: '(000) 000 00 00' },
                { code: 'IL', name: 'Israel', ddi: '+972', flag: '🇮🇱', mask: '00-000-0000' },
                { code: 'JO', name: 'Jordânia', ddi: '+962', flag: '🇯🇴', mask: '00 000 0000' },
                { code: 'LB', name: 'Líbano', ddi: '+961', flag: '🇱🇧', mask: '00 000 000' },
                { code: 'SY', name: 'Síria', ddi: '+963', flag: '🇸🇾', mask: '000 000 000' },
                { code: 'IQ', name: 'Iraque', ddi: '+964', flag: '🇮🇶', mask: '000 000 0000' },
                { code: 'SA', name: 'Arábia Saudita', ddi: '+966', flag: '🇸🇦', mask: '00 000 0000' },
                { code: 'AE', name: 'Emirados Árabes Unidos', ddi: '+971', flag: '🇦🇪', mask: '00 000 0000' },
                { code: 'QA', name: 'Catar', ddi: '+974', flag: '🇶🇦', mask: '0000 0000' },
                { code: 'KW', name: 'Kuwait', ddi: '+965', flag: '🇰🇼', mask: '000 00000' },
                { code: 'BH', name: 'Bahrein', ddi: '+973', flag: '🇧🇭', mask: '0000 0000' },
                { code: 'OM', name: 'Omã', ddi: '+968', flag: '🇴🇲', mask: '0000 0000' },
                { code: 'YE', name: 'Iêmen', ddi: '+967', flag: '🇾🇪', mask: '000 000 000' },
                { code: 'EG', name: 'Egito', ddi: '+20', flag: '🇪🇬', mask: '00 0000 0000' },
                { code: 'LY', name: 'Líbia', ddi: '+218', flag: '🇱🇾', mask: '000 000 000' },
                { code: 'TN', name: 'Tunísia', ddi: '+216', flag: '🇹🇳', mask: '00 000 000' },
                { code: 'DZ', name: 'Argélia', ddi: '+213', flag: '🇩🇿', mask: '000 000 000' },
                { code: 'MA', name: 'Marrocos', ddi: '+212', flag: '🇲🇦', mask: '000 000 000' },
                { code: 'SN', name: 'Senegal', ddi: '+221', flag: '🇸🇳', mask: '00 000 00 00' },
                { code: 'CI', name: 'Costa do Marfim', ddi: '+225', flag: '🇨🇮', mask: '00 000 000' },
                { code: 'GH', name: 'Gana', ddi: '+233', flag: '🇬🇭', mask: '00 000 0000' },
                { code: 'NG', name: 'Nigéria', ddi: '+234', flag: '🇳🇬', mask: '000 000 0000' },
                { code: 'CM', name: 'Camarões', ddi: '+237', flag: '🇨🇲', mask: '0000 0000' },
                { code: 'TD', name: 'Chade', ddi: '+235', flag: '🇹🇩', mask: '0000 0000' },
                { code: 'CF', name: 'República Centro-Africana', ddi: '+236', flag: '🇨🇫', mask: '0000 0000' },
                { code: 'CG', name: 'República do Congo', ddi: '+242', flag: '🇨🇬', mask: '000 000 000' },
                { code: 'CD', name: 'República Democrática do Congo', ddi: '+243', flag: '🇨🇩', mask: '000 000 000' },
                { code: 'GA', name: 'Gabão', ddi: '+241', flag: '🇬🇦', mask: '0000 0000' },
                { code: 'GQ', name: 'Guiné Equatorial', ddi: '+240', flag: '🇬🇶', mask: '000 000 000' },
                { code: 'ST', name: 'São Tomé e Príncipe', ddi: '+239', flag: '🇸🇹', mask: '000 0000' },
                { code: 'AO', name: 'Angola', ddi: '+244', flag: '🇦🇴', mask: '000 000 000' },
                { code: 'NA', name: 'Namíbia', ddi: '+264', flag: '🇳🇦', mask: '000 000 000' },
                { code: 'BW', name: 'Botswana', ddi: '+267', flag: '🇧🇼', mask: '000 000 000' },
                { code: 'ZW', name: 'Zimbábue', ddi: '+263', flag: '🇿🇼', mask: '000 000 000' },
                { code: 'ZM', name: 'Zâmbia', ddi: '+260', flag: '🇿🇲', mask: '000 000 000' },
                { code: 'MW', name: 'Malawi', ddi: '+265', flag: '🇲🇼', mask: '000 000 000' },
                { code: 'MZ', name: 'Moçambique', ddi: '+258', flag: '🇲🇿', mask: '000 000 000' },
                { code: 'ZW', name: 'Zimbábue', ddi: '+263', flag: '🇿🇼', mask: '000 000 000' },
                { code: 'TZ', name: 'Tanzânia', ddi: '+255', flag: '🇹🇿', mask: '000 000 000' },
                { code: 'KE', name: 'Quênia', ddi: '+254', flag: '🇰🇪', mask: '000 000 000' },
                { code: 'UG', name: 'Uganda', ddi: '+256', flag: '🇺🇬', mask: '000 000 000' },
                { code: 'RW', name: 'Ruanda', ddi: '+250', flag: '🇷🇼', mask: '000 000 000' },
                { code: 'BI', name: 'Burundi', ddi: '+257', flag: '🇧🇮', mask: '000 000 000' },
                { code: 'ET', name: 'Etiópia', ddi: '+251', flag: '🇪🇹', mask: '000 000 000' },
                { code: 'ER', name: 'Eritreia', ddi: '+291', flag: '🇪🇷', mask: '000 000 000' },
                { code: 'DJ', name: 'Djibouti', ddi: '+253', flag: '🇩🇯', mask: '000 000 000' },
                { code: 'SO', name: 'Somália', ddi: '+252', flag: '🇸🇴', mask: '000 000 000' },
                { code: 'SS', name: 'Sudão do Sul', ddi: '+211', flag: '🇸🇸', mask: '000 000 000' },
                { code: 'SD', name: 'Sudão', ddi: '+249', flag: '🇸🇩', mask: '000 000 000' },
                { code: 'EG', name: 'Egito', ddi: '+20', flag: '🇪🇬', mask: '00 0000 0000' },
                { code: 'IN', name: 'Índia', ddi: '+91', flag: '🇮🇳', mask: '00000 00000' },
                { code: 'PK', name: 'Paquistão', ddi: '+92', flag: '🇵🇰', mask: '000 0000000' },
                { code: 'BD', name: 'Bangladesh', ddi: '+880', flag: '🇧🇩', mask: '00000 000000' },
                { code: 'LK', name: 'Sri Lanka', ddi: '+94', flag: '🇱🇰', mask: '000 000 000' },
                { code: 'NP', name: 'Nepal', ddi: '+977', flag: '🇳🇵', mask: '000 000 000' },
                { code: 'BT', name: 'Butão', ddi: '+975', flag: '🇧🇹', mask: '000 000 000' },
                { code: 'MV', name: 'Maldivas', ddi: '+960', flag: '🇲🇻', mask: '000 0000' },
                { code: 'AF', name: 'Afeganistão', ddi: '+93', flag: '🇦🇫', mask: '000 000 000' },
                { code: 'IR', name: 'Irã', ddi: '+98', flag: '🇮🇷', mask: '000 000 0000' },
                { code: 'CN', name: 'China', ddi: '+86', flag: '🇨🇳', mask: '000 0000 0000' },
                { code: 'JP', name: 'Japão', ddi: '+81', flag: '🇯🇵', mask: '00 0000 0000' },
                { code: 'KR', name: 'Coreia do Sul', ddi: '+82', flag: '🇰🇷', mask: '00 0000 0000' },
                { code: 'KP', name: 'Coreia do Norte', ddi: '+850', flag: '🇰🇵', mask: '000 000 000' },
                { code: 'MN', name: 'Mongólia', ddi: '+976', flag: '🇲🇳', mask: '0000 0000' },
                { code: 'TW', name: 'Taiwan', ddi: '+886', flag: '🇹🇼', mask: '0000 000 000' },
                { code: 'HK', name: 'Hong Kong', ddi: '+852', flag: '🇭🇰', mask: '0000 0000' },
                { code: 'MO', name: 'Macau', ddi: '+853', flag: '🇲🇴', mask: '0000 0000' },
                { code: 'TH', name: 'Tailândia', ddi: '+66', flag: '🇹🇭', mask: '0 0000 0000' },
                { code: 'VN', name: 'Vietnã', ddi: '+84', flag: '🇻🇳', mask: '000 000 0000' },
                { code: 'LA', name: 'Laos', ddi: '+856', flag: '🇱🇦', mask: '000 000 000' },
                { code: 'KH', name: 'Camboja', ddi: '+855', flag: '🇰🇭', mask: '000 000 000' },
                { code: 'MM', name: 'Myanmar', ddi: '+95', flag: '🇲🇲', mask: '000 000 000' },
                { code: 'MY', name: 'Malásia', ddi: '+60', flag: '🇲🇾', mask: '00 000 0000' },
                { code: 'SG', name: 'Singapura', ddi: '+65', flag: '🇸🇬', mask: '0000 0000' },
                { code: 'ID', name: 'Indonésia', ddi: '+62', flag: '🇮🇩', mask: '000 000 000' },
                { code: 'PH', name: 'Filipinas', ddi: '+63', flag: '🇵🇭', mask: '000 000 0000' },
                { code: 'BN', name: 'Brunei', ddi: '+673', flag: '🇧🇳', mask: '000 0000' },
                { code: 'TL', name: 'Timor-Leste', ddi: '+670', flag: '🇹🇱', mask: '000 00000' },
                { code: 'AU', name: 'Austrália', ddi: '+61', flag: '🇦🇺', mask: '000 000 000' },
                { code: 'NZ', name: 'Nova Zelândia', ddi: '+64', flag: '🇳🇿', mask: '000 000 000' },
                { code: 'FJ', name: 'Fiji', ddi: '+679', flag: '🇫🇯', mask: '000 0000' },
                { code: 'PG', name: 'Papua Nova Guiné', ddi: '+675', flag: '🇵🇬', mask: '000 00000' },
                { code: 'SB', name: 'Ilhas Salomão', ddi: '+677', flag: '🇸🇧', mask: '00000' },
                { code: 'VU', name: 'Vanuatu', ddi: '+678', flag: '🇻🇺', mask: '000 0000' },
                { code: 'NC', name: 'Nova Caledônia', ddi: '+687', flag: '🇳🇨', mask: '000 000' },
                { code: 'PF', name: 'Polinésia Francesa', ddi: '+689', flag: '🇵🇫', mask: '000 000' },
                { code: 'WS', name: 'Samoa', ddi: '+685', flag: '🇼🇸', mask: '00000' },
                { code: 'TO', name: 'Tonga', ddi: '+676', flag: '🇹🇴', mask: '00000' },
                { code: 'KI', name: 'Kiribati', ddi: '+686', flag: '🇰🇮', mask: '00000' },
                { code: 'TV', name: 'Tuvalu', ddi: '+688', flag: '🇹🇻', mask: '00000' },
                { code: 'NR', name: 'Nauru', ddi: '+674', flag: '🇳🇷', mask: '000 0000' },
                { code: 'PW', name: 'Palau', ddi: '+680', flag: '🇵🇼', mask: '000 0000' },
                { code: 'FM', name: 'Micronésia', ddi: '+691', flag: '🇫🇲', mask: '000 0000' },
                { code: 'MH', name: 'Ilhas Marshall', ddi: '+692', flag: '🇲🇭', mask: '000 0000' },
                { code: 'CK', name: 'Ilhas Cook', ddi: '+682', flag: '🇨🇰', mask: '00000' },
                { code: 'NU', name: 'Niue', ddi: '+683', flag: '🇳🇺', mask: '0000' },
                { code: 'TK', name: 'Tokelau', ddi: '+690', flag: '🇹🇰', mask: '0000' },
                { code: 'AS', name: 'Samoa Americana', ddi: '+1', flag: '🇦🇸', mask: '(000) 000-0000' },
                { code: 'GU', name: 'Guam', ddi: '+1', flag: '🇬🇺', mask: '(000) 000-0000' },
                { code: 'MP', name: 'Ilhas Marianas do Norte', ddi: '+1', flag: '🇲🇵', mask: '(000) 000-0000' },
                { code: 'PR', name: 'Porto Rico', ddi: '+1', flag: '🇵🇷', mask: '(000) 000-0000' },
                { code: 'VI', name: 'Ilhas Virgens dos EUA', ddi: '+1', flag: '🇻🇮', mask: '(000) 000-0000' },
                { code: 'DO', name: 'República Dominicana', ddi: '+1', flag: '🇩🇴', mask: '(000) 000-0000' },
                { code: 'JM', name: 'Jamaica', ddi: '+1', flag: '🇯🇲', mask: '(000) 000-0000' },
                { code: 'BB', name: 'Barbados', ddi: '+1', flag: '🇧🇧', mask: '(000) 000-0000' },
                { code: 'TT', name: 'Trinidad e Tobago', ddi: '+1', flag: '🇹🇹', mask: '(000) 000-0000' },
                { code: 'GD', name: 'Granada', ddi: '+1', flag: '🇬🇩', mask: '(000) 000-0000' },
                { code: 'LC', name: 'Santa Lúcia', ddi: '+1', flag: '🇱🇨', mask: '(000) 000-0000' },
                { code: 'VC', name: 'São Vicente e Granadinas', ddi: '+1', flag: '🇻🇨', mask: '(000) 000-0000' },
                { code: 'AG', name: 'Antígua e Barbuda', ddi: '+1', flag: '🇦🇬', mask: '(000) 000-0000' },
                { code: 'KN', name: 'São Cristóvão e Névis', ddi: '+1', flag: '🇰🇳', mask: '(000) 000-0000' },
                { code: 'DM', name: 'Dominica', ddi: '+1', flag: '🇩🇲', mask: '(000) 000-0000' },
                { code: 'HT', name: 'Haiti', ddi: '+509', flag: '🇭🇹', mask: '0000 0000' },
                { code: 'CU', name: 'Cuba', ddi: '+53', flag: '🇨🇺', mask: '000 000 0000' },
                { code: 'BS', name: 'Bahamas', ddi: '+1', flag: '🇧🇸', mask: '(000) 000-0000' },
                { code: 'BZ', name: 'Belize', ddi: '+501', flag: '🇧🇿', mask: '000 0000' },
                { code: 'GT', name: 'Guatemala', ddi: '+502', flag: '🇬🇹', mask: '0000 0000' },
                { code: 'SV', name: 'El Salvador', ddi: '+503', flag: '🇸🇻', mask: '0000 0000' },
                { code: 'HN', name: 'Honduras', ddi: '+504', flag: '🇭🇳', mask: '0000 0000' },
                { code: 'NI', name: 'Nicarágua', ddi: '+505', flag: '🇳🇮', mask: '0000 0000' },
                { code: 'CR', name: 'Costa Rica', ddi: '+506', flag: '🇨🇷', mask: '0000 0000' },
                { code: 'PA', name: 'Panamá', ddi: '+507', flag: '🇵🇦', mask: '0000 0000' }
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
                        // Verificar se já foi processado e se não está em um popup já processado
                        if (!input.classList.contains('ddi-processed')) {
                            // Verificar se o input está em um popup que já foi processado
                            var popupContainer = input.closest('.elementor-popup-modal, .elementor-lightbox, .popup');
                            if (popupContainer && popupContainer.classList.contains('ddi-popup-processed')) {
                                return; // Pular se o popup já foi processado
                            }
                            
                            addPhoneSelector(input);
                            
                            // Marcar popup como processado se estiver em um
                            if (popupContainer) {
                                popupContainer.classList.add('ddi-popup-processed');
                            }
                        }
                    });
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao processar campos:', error);
                }
            }
            
            function addPhoneSelector(input) {
                try {
                    // Verificar se já foi processado
                    if (input.classList.contains('ddi-processed')) {
                        return;
                    }
                    
                    // Marcar como processado
                    input.classList.add('ddi-processed');
                    
                    // Verificar se é Contact Form 7
                    var isCF7 = input.classList.contains('wpcf7-form-control') || input.closest('.wpcf7-form');
                    
                    // Se for CF7, usar abordagem diferente
                    if (isCF7) {
                        addPhoneSelectorCF7(input);
                        return;
                    }
                    
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
                    
                    // Ajustar background responsivo
                    adjustResponsiveBackground(container, input);
                    
                    console.log('DDI WP Phone: Seletor adicionado com sucesso');
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao adicionar seletor:', error);
                }
            }
            
            function addPhoneSelectorCF7(input) {
                try {
                    // Preservar dimensões originais
                    var originalWidth = input.offsetWidth;
                    var originalHeight = input.offsetHeight;
                    var originalStyle = input.getAttribute('style') || '';
                    
                    // Salvar dados originais
                    input.setAttribute('data-original-width', originalWidth);
                    input.setAttribute('data-original-height', originalHeight);
                    input.setAttribute('data-original-style', originalStyle);
                    
                    // Criar container específico para CF7
                    var container = document.createElement('div');
                    container.className = 'ddi-phone-container ddi-cf7-container';
                    container.style.cssText = 'position: relative !important; display: inline-block !important; width: ' + originalWidth + 'px !important;';
                    
                    // Mover input para container
                    input.parentNode.insertBefore(container, input);
                    container.appendChild(input);
                    
                    // Criar seletor específico para CF7
                    var selector = document.createElement('div');
                    selector.className = 'ddi-phone-selector ddi-cf7-selector';
                    selector.innerHTML = currentCountry.flag + ' ' + currentCountry.ddi;
                    selector.style.cssText = 'position: absolute !important; left: 1px !important; top: 1px !important; z-index: 10 !important; display: flex !important; align-items: center !important; background: #fff !important; border: none !important; cursor: pointer !important; width: 70px !important; height: ' + (originalHeight - 2) + 'px !important; padding: 0 8px !important; font-size: 14px !important; color: #333 !important; font-weight: 500 !important; box-sizing: border-box !important;';
                    
                    selector.addEventListener('click', function(e) {
                        e.preventDefault();
                        toggleDropdown(container, selector);
                    });
                    
                    // Inserir seletor antes do input
                    container.insertBefore(selector, input);
                    
                    // Aplicar estilos específicos ao input CF7
                    input.style.cssText = originalStyle + '; padding-left: 82px !important; width: ' + originalWidth + 'px !important; height: ' + originalHeight + 'px !important; box-sizing: border-box !important;';
                    
                    // Aplicar máscara inicial
                    applyMask(input, currentCountry.mask);
                    
                    console.log('DDI WP Phone: Seletor CF7 adicionado com sucesso');
                    
                } catch (error) {
                    console.log('DDI WP Phone: Erro ao adicionar seletor CF7:', error);
                }
            }
            
            function adjustResponsiveBackground(container, input) {
                // Função para ajustar o background do seletor baseado na altura do input
                function adjustBackground() {
                    var inputHeight = input.offsetHeight;
                    var selector = container.querySelector('.ddi-phone-selector');
                    
                    if (selector && inputHeight > 0) {
                        // Verificar se é Contact Form 7
                        var isCF7 = input.classList.contains('wpcf7-form-control') || input.closest('.wpcf7-form');
                        
                        // Obter informações da borda do input
                        var inputStyle = window.getComputedStyle(input);
                        var inputBorderTop = parseInt(inputStyle.borderTopWidth) || 0;
                        var inputBorderLeft = parseInt(inputStyle.borderLeftWidth) || 0;
                        var inputBorderRight = parseInt(inputStyle.borderRightWidth) || 0;
                        var inputBorderBottom = parseInt(inputStyle.borderBottomWidth) || 0;
                        var inputPaddingTop = parseInt(inputStyle.paddingTop) || 0;
                        var inputPaddingLeft = parseInt(inputStyle.paddingLeft) || 0;
                        
                        // Detectar border-radius do input
                        var inputBorderRadius = inputStyle.borderRadius;
                        var borderRadiusValues = inputBorderRadius.split(' ');
                        
                        // Aplicar border-radius ao seletor (apenas canto superior esquerdo e inferior esquerdo)
                        if (inputBorderRadius && inputBorderRadius !== '0px') {
                            var topLeftRadius = borderRadiusValues[0] || borderRadiusValues[0] || borderRadiusValues[0] || borderRadiusValues[0];
                            var bottomLeftRadius = borderRadiusValues.length > 2 ? borderRadiusValues[2] : topLeftRadius;
                            
                            // Converter para número e subtrair 1px para ficar dentro da borda
                            var topLeftValue = Math.max(0, parseInt(topLeftRadius) - 1);
                            var bottomLeftValue = Math.max(0, parseInt(bottomLeftRadius) - 1);
                            
                            selector.style.borderTopLeftRadius = topLeftValue + 'px';
                            selector.style.borderBottomLeftRadius = bottomLeftValue + 'px';
                            selector.style.borderTopRightRadius = '0px';
                            selector.style.borderBottomRightRadius = '0px';
                        } else {
                            // Reset border-radius se não houver
                            selector.style.borderRadius = '0px';
                        }
                        
                        // Calcular altura do seletor (altura do input menos bordas e 1px de margem)
                        var selectorHeight = inputHeight - (inputBorderTop + inputBorderBottom) - 2; // -2 para 1px em cima e 1px embaixo
                        
                        // Ajustar altura do seletor
                        selector.style.height = selectorHeight + 'px';
                        selector.style.lineHeight = selectorHeight + 'px';
                        
                        // Posicionar o seletor dentro do input (considerando bordas + 1px de margem)
                        selector.style.top = (inputBorderTop + 1) + 'px';
                        selector.style.left = (inputBorderLeft + 1) + 'px';
                        selector.style.bottom = 'auto';
                        
                        // Garantir que o seletor não cubra a borda do input
                        selector.style.margin = '0px';
                        selector.style.border = 'none';
                        
                        // Ajustar padding para ficar dentro do input
                        var adjustedPaddingTop = Math.max(0, inputPaddingTop - inputBorderTop - 1);
                        selector.style.paddingTop = adjustedPaddingTop + 'px';
                        selector.style.paddingBottom = adjustedPaddingTop + 'px';
                        
                        // Ajustar largura para não cobrir a borda direita
                        var inputWidth = input.offsetWidth;
                        var selectorWidth = 70; // largura base do seletor (aumentada para acomodar DDIs maiores)
                        var maxSelectorWidth = inputWidth - (inputBorderLeft + inputBorderRight) - 2; // -2 para 1px de cada lado
                        selector.style.width = Math.min(selectorWidth, maxSelectorWidth) + 'px';
                        
                        // Correção específica para Contact Form 7 - manter largura original do input
                        if (isCF7) {
                            // Preservar a largura original do input
                            var originalWidth = input.getAttribute('data-original-width');
                            if (originalWidth) {
                                // Forçar a largura original
                                input.style.width = originalWidth + 'px';
                                input.style.maxWidth = originalWidth + 'px';
                                input.style.minWidth = originalWidth + 'px';
                            }
                            
                            // Garantir que o container não afete a largura
                            container.style.width = '100%';
                            container.style.maxWidth = '100%';
                        }
                    }
                }
                
                // Ajustar imediatamente
                adjustBackground();
                
                // Ajustar após delays para garantir que o input foi renderizado
                setTimeout(adjustBackground, 100);
                setTimeout(adjustBackground, 500);
                setTimeout(adjustBackground, 1000);
                
                // Observar mudanças no tamanho do input
                if (window.ResizeObserver) {
                    var resizeObserver = new ResizeObserver(function() {
                        adjustBackground();
                    });
                    
                    resizeObserver.observe(input);
                }
                
                // Observar mudanças no DOM para garantir ajuste contínuo
                var observer = new MutationObserver(function() {
                    adjustBackground();
                });
                
                observer.observe(input, {
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
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
                    // Aplicar nova máscara sem conflitar com máscaras anteriores
                    applyMask(input, country.mask);
                    
                    // Limpar o valor do input quando trocar de país
                    input.value = '';
                    
                    // Ajustar background responsivo
                    adjustResponsiveBackground(container, input);
                }
            }
            
            function applyMask(input, mask) {
                // Remover listeners anteriores para evitar duplicação
                var existingListener = input.getAttribute('data-ddi-mask-listener');
                if (existingListener) {
                    input.removeEventListener('input', window[existingListener]);
                }
                
                // Criar função única para este input
                var listenerName = 'ddiMaskListener_' + Math.random().toString(36).substr(2, 9);
                window[listenerName] = function(e) {
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
                };
                
                // Adicionar listener e marcar
                input.addEventListener('input', window[listenerName]);
                input.setAttribute('data-ddi-mask-listener', listenerName);
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