# 📚 Documentação - Eletrônica Oriental

Bem-vindo à documentação do Sistema de Gestão Eletrônica Oriental. Esta documentação está organizada por categorias para facilitar a navegação.

> **Atenção:** Docker e Docker Compose são usados apenas para desenvolvimento local. Para deploy em produção, siga as instruções do README principal na raiz do projeto.

## 🐳 Docker

Documentação relacionada ao ambiente Docker e desenvolvimento.

- **[Setup e Instalação](./docker/setup.md)** - Configuração inicial do ambiente Docker
- **[Desenvolvimento](./docker/development.md)** - Comandos e scripts para desenvolvimento

## 🔗 Integrações

Documentação sobre integrações com sistemas externos.

- **[WhatsApp Business API](./integrations/whatsapp.md)** - Integração com WhatsApp Business
- **[Sistemas de Pagamento](./integrations/payment.md)** - Integração com gateways de pagamento

## 🔧 Técnico

Documentação técnica do projeto.

- **[DTOs](./technical/dtos.md)** - Documentação dos Data Transfer Objects
- **[API Mobile Preparation](./technical/api-mobile-preparation.md)** - Preparação para API mobile
- **[Enums e Traits](./technical/enums-and-traits.md)** - Documentação dos enums e traits implementados
- **[Testes](./technical/testing.md)** - Estratégia e padrões de testes
- **[Dashboard Services](./technical/dashboard-services.md)** - Documentação dos serviços de dashboard
- **[Controller Standardization](./technical/controller-standardization.md)** - Padronização de controllers com injeção de dependência
- **[Routes Modularization](./technical/routes-modularization.md)** - Modularização de rotas por contexto

## 📊 Estrutura do Banco

Documentação sobre a estrutura do banco de dados.

- **[Estrutura do Banco de Dados](./estrutura_banco.md)** - Documentação completa da estrutura do banco de dados, relacionamentos e mudanças recentes

## 📚 Tutoriais

Guias práticos e tutoriais.

- **[Configuração de Email](./tutorials/email-setup.md)** - Configuração de email para notificações
- **[Configuração de WhatsApp](./tutorials/whatsapp-setup.md)** - Configuração do WhatsApp Business
- **[Gestão de Clientes](./tutorials/client-management.md)** - Tutorial para gestão de clientes
- **[Gestão de Ordens de Serviço](./tutorials/service-orders.md)** - Tutorial para gestão de ordens de serviço

## 🚀 Como usar esta documentação

1. **Novo no projeto?** Comece pelo [README principal](../README.md)
2. **Configurando ambiente?** Consulte [Setup Docker](./docker/setup.md)
3. **Desenvolvendo?** Use [Desenvolvimento Docker](./docker/development.md)
4. **Integrando automações?** Veja [WhatsApp](./integrations/whatsapp.md)
5. **Precisa de tutoriais?** Acesse [Tutoriais](./tutorials/)
6. **Entendendo o banco?** Consulte [Estrutura do Banco](./estrutura_banco.md)

## 📝 Contribuindo com a documentação

Para manter a documentação atualizada:

1. **Atualize links** quando mover arquivos
2. **Adicione exemplos práticos** nos tutoriais
3. **Mantenha consistência** na formatação
4. **Teste comandos** antes de documentar
5. **Atualize a estrutura do banco** quando houver mudanças nas migrations

## 🧪 Status dos Testes

- **Total de Testes:** Em desenvolvimento
- **Cobertura:** Em implementação
- **Controllers:** Em desenvolvimento
- **Services:** Em desenvolvimento
- **Models:** Em desenvolvimento

## 🏗️ Estrutura do Projeto

### Principais Diretórios
```
├── app
│   ├── Http
│   │   ├── Controllers      # Controladores por função
│   │   │   ├── Auth/        # Autenticação
│   │   │   └── ...          # Outros controllers
│   │   ├── Middleware       # Middlewares da aplicação
│   │   └── Requests        # Form Requests para validação
│   ├── Models              # Modelos do Eloquent
│   └── Services           # Camada de serviços organizada por perfil
│       ├── Common/         # Serviços comuns a todos os perfis
│       ├── Proprietario/   # Serviços específicos do proprietário
│       ├── Tecnico/        # Serviços específicos do técnico
│       ├── Atendente/      # Serviços específicos do atendente
│       ├── Relatorios/     # Serviços de relatórios
│       └── Dashboards/     # Serviços de dashboard
├── database
│   ├── migrations         # Migrações do banco de dados
│   └── seeders           # Seeders para dados iniciais
├── docker
│   ├── caddy             # Configurações do Caddy
│   ├── mysql            # Configurações do MySQL
│   └── php              # Configurações do PHP
├── resources
│   ├── js
│   │   ├── Components    # Componentes Vue reutilizáveis
│   │   ├── Layouts      # Layouts da aplicação
│   │   └── Pages        # Páginas Vue.js
│   └── views            # Views Laravel (emails)
└── tests                # Testes automatizados
```

## 👥 Perfis de Usuário

O sistema possui quatro tipos de usuários:
- **Admin**: Gerenciamento completo do sistema
- **Proprietário**: Gestão de clientes, orçamentos e ordens de serviço
- **Técnico**: Execução de serviços e reparos
- **Atendente**: Atendimento ao cliente e gestão básica

## 📝 Funcionalidades

### Módulo Proprietário
- Gestão de clientes (CRUD)
- Gestão de orçamentos (CRUD)
- Gestão de ordens de serviço (CRUD)
- Relatórios financeiros
- Dashboard com métricas

### Módulo Técnico
- Visualização de ordens de serviço
- Registro de serviços realizados
- Controle de peças utilizadas
- Registro de garantias

### Módulo Atendente
- Atendimento ao cliente
- Criação de orçamentos básicos
- Agendamento de serviços
- Controle de status

---

**💡 Dica:** Use o [README principal](../README.md) como ponto de entrada e navegue para as seções específicas conforme necessário. 
