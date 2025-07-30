# DDI WP Phone Plugin

Plugin WordPress para gerenciamento de números DDI (Discagem Direta Internacional).

## Descrição

Este plugin permite gerenciar e exibir números de telefone com DDI de forma organizada e responsiva no WordPress. Adiciona um seletor de DDI (código de discagem internacional) com bandeiras de países a campos de telefone em formulários populares do WordPress, aplicando máscaras de telefone dinamicamente.

## Funcionalidades

- **Seletor de DDI com Bandeiras**: Interface visual com bandeiras de países
- **Máscaras de Telefone Dinâmicas**: Aplicação automática de máscaras baseadas no país selecionado
- **Integração com Elementor Pro**: Funciona em formulários do Elementor
- **Integração com Contact Form 7**: Suporte completo ao CF7
- **Integração com WooCommerce**: Funciona no checkout e páginas de conta
- **Interface Responsiva**: Adaptável a diferentes tamanhos de tela
- **Configurações Administrativas**: Painel de configurações personalizável

## Requisitos

- WordPress 5.0 ou superior
- PHP 7.4 ou superior
- jQuery (incluído no WordPress)

## Instalação

1. Faça upload do plugin para a pasta `/wp-content/plugins/`
2. Ative o plugin através do menu 'Plugins' no WordPress
3. Configure as opções do plugin em Configurações > DDI WP Phone

## Uso

### Elementor Pro
O plugin detecta automaticamente campos de telefone em formulários do Elementor e aplica o seletor de DDI.

### Contact Form 7
Use o shortcode `[tel]` normalmente. O plugin irá automaticamente adicionar o seletor de DDI.

### WooCommerce
O plugin funciona automaticamente nos campos de telefone do checkout e páginas de conta.

## Configurações

- **País Padrão**: Define o país padrão para ser exibido
- **Exibir Código DDI**: Mostra ou oculta o código numérico do DDI
- **Tamanho do Seletor**: Ajusta a largura do seletor de bandeira

## Estrutura do Projeto

```
/ddi-wp-phone/
|-- assets/
|   |-- css/
|   |   |-- ddi-wp-phone-main.css
|   |   |-- flag-icons.min.css
|   |-- js/
|   |   |-- ddi-wp-phone-main.js
|   |   |-- libphonenumber-js.min.js
|   |-- vendor/
|       |-- flag-icons/
|-- includes/
|   |-- class-ddi-wp-phone-core.php
|   |-- class-ddi-wp-phone-assets.php
|-- integrations/
|   |-- class-elementor-integration.php
|   |-- class-cf7-integration.php
|   |-- class-woocommerce-integration.php
|-- admin/
|   |-- class-admin-settings.php
|-- ddi-wp-phone.php
```

## Bibliotecas Utilizadas

- **flag-icons**: Para exibir os ícones das bandeiras
- **libphonenumber-js**: Para obter a lista de países e aplicar máscaras de telefone

## Desenvolvimento

Este projeto está em desenvolvimento ativo.

### Módulos Implementados

- ✅ **Módulo 1**: Integração com Elementor Pro
- ⏳ **Módulo 2**: Integração com Contact Form 7
- ⏳ **Módulo 3**: Integração com WooCommerce
- ⏳ **Módulo 4**: Área Administrativa

## Licença

GPL v2 ou posterior

## Autor

**Wplugin** - https://www.wplugin.com.br

## Suporte

Para suporte e dúvidas, entre em contato através do site oficial. 