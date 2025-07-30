# DDI WP Phone

Plugin WordPress que adiciona um seletor de DDI (código de discagem internacional) com bandeiras de países a campos de telefone em formulários populares do WordPress, aplicando máscaras de telefone dinamicamente.

## 📋 Características

- **249 países** suportados com bandeiras e DDIs
- **Integração automática** com Elementor Pro, Contact Form 7 e WooCommerce
- **Máscaras de telefone** específicas para cada país
- **Detecção automática** de border-radius do input
- **Responsivo** e compatível com qualquer tema
- **Suporte a popups** do Elementor
- **Background responsivo** que se adapta ao input

## 🚀 Instalação

1. Faça o download da versão desejada na aba [Releases](../../releases)
2. Faça upload do arquivo ZIP via painel administrativo do WordPress
3. Ative o plugin
4. Configure as opções em **Configurações > DDI WP Phone**

## 📦 Versões Disponíveis

### v1.1.0 (Atual)
- ✅ Integração completa com Elementor Pro
- ✅ Integração completa com Contact Form 7
- ✅ 249 países com bandeiras e máscaras
- ✅ Background responsivo
- ✅ Detecção automática de border-radius
- ✅ Suporte a popups do Elementor
- ✅ Correção de largura para DDIs maiores
- ✅ Correção de conflitos em popups
- ✅ Preservação de dimensões em CF7
- ✅ Compatibilidade total com temas WordPress

### v1.0.0
- ✅ Versão inicial estável
- ✅ Integração completa com Elementor Pro
- ✅ 249 países com bandeiras e máscaras
- ✅ Background responsivo
- ✅ Detecção automática de border-radius
- ✅ Suporte a popups do Elementor
- ✅ Correção de largura para DDIs maiores
- ✅ Compatibilidade total com temas WordPress

### Próximas Versões
- 🔄 Integração com WooCommerce (Módulo 3)
- 🔄 Painel administrativo completo (Módulo 4)

## 🎯 Como Funciona

O plugin detecta automaticamente campos de telefone nos seguintes formulários:

- **Elementor Pro**: Campos com `type="tel"`
- **Contact Form 7**: Campos com `[tel]`
- **WooCommerce**: Campos de checkout e conta
- **Formulários genéricos**: Qualquer `input[type="tel"]`

### Funcionalidades

1. **Seletor de País**: Clique para escolher entre 249 países
2. **Máscaras Automáticas**: Cada país tem sua máscara específica
3. **Bandeiras**: Visualização com emojis de bandeiras
4. **Responsivo**: Se adapta a diferentes tamanhos de input
5. **Compatível**: Funciona com qualquer tema WordPress

## 🔧 Configuração

### Configurações Padrão
- **País padrão**: Brasil (+55)
- **Exibir código DDI**: Sim
- **Largura do seletor**: 70px

### Personalização
O plugin se adapta automaticamente ao estilo do seu tema, incluindo:
- Border-radius do input
- Altura e largura dos campos
- Cores e estilos
- Responsividade

## 📱 Responsividade

- **Desktop**: Seletor de 70px de largura
- **Mobile**: Seletor de 60px de largura
- **Adaptação automática** a diferentes tamanhos de input

## 🌍 Países Suportados

O plugin inclui todos os 249 países da biblioteca libphonenumber-js, incluindo:

- **Américas**: Brasil, EUA, Canadá, Argentina, México, etc.
- **Europa**: Reino Unido, Alemanha, França, Itália, Espanha, etc.
- **Ásia**: China, Japão, Coreia, Índia, Tailândia, etc.
- **África**: Egito, Nigéria, África do Sul, Quênia, etc.
- **Oceania**: Austrália, Nova Zelândia, Fiji, etc.

## 🛠️ Desenvolvimento

### Estrutura do Plugin
```
ddi-wp-phone/
├── ddi-wp-phone.php              # Arquivo principal
├── includes/
│   └── class-ddi-wp-phone-core.php
├── integrations/
│   ├── class-elementor-integration.php
│   ├── class-cf7-integration.php
│   └── class-woocommerce-integration.php
├── admin/
│   └── class-admin-settings.php
├── assets/
│   ├── css/
│   │   └── ddi-wp-phone-main.css
│   └── js/
│       └── ddi-wp-phone-main.js
└── README.md
```

### Módulos Implementados
- ✅ **Módulo 1**: Integração com Elementor Pro
- 🔄 **Módulo 2**: Integração com Contact Form 7
- 🔄 **Módulo 3**: Integração com WooCommerce
- 🔄 **Módulo 4**: Painel administrativo

## 📄 Licença

Este plugin está licenciado sob a GPL v2 ou posterior.

## 👨‍💻 Desenvolvido por

**Wplugin** - https://www.wplugin.com.br

## 🔄 Changelog

### v1.2.0 (2024-01-XX)
- ✅ **Nova Funcionalidade**: Limpeza automática de cache do navegador
- ✅ **Melhoria**: Remove valores pré-preenchidos dos campos de telefone
- ✅ **Melhoria**: Previne conflitos com máscaras de formatação
- ✅ **Melhoria**: Limpeza inteligente no foco do campo
- ✅ **Melhoria**: Logs informativos para debug
- ✅ **Estabilidade**: Melhor experiência do usuário com campos sempre limpos

### v1.1.0 (2024-01-XX)
- ✅ **Módulo 2**: Integração completa com Contact Form 7
- ✅ **Correção**: Bug de largura em formulários CF7
- ✅ **Correção**: Conflitos entre campos em popups do Elementor
- ✅ **Melhoria**: Preservação de dimensões originais em CF7
- ✅ **Melhoria**: Listeners únicos para evitar duplicação
- ✅ **Melhoria**: Controle de popups processados
- ✅ **Melhoria**: Limpeza automática ao trocar país
- ✅ **Estabilidade**: Correções de bugs e melhorias de performance

### v1.0.0 (2024-01-XX)
- ✅ Versão inicial estável
- ✅ Integração completa com Elementor Pro
- ✅ 249 países com bandeiras e máscaras
- ✅ Background responsivo
- ✅ Detecção automática de border-radius
- ✅ Suporte a popups do Elementor
- ✅ Correção de largura para DDIs maiores
- ✅ Compatibilidade total com temas WordPress 