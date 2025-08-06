# 🏪 Eletrônica Oriental - Sistema de Gestão

Sistema de gestão para empresa de eletrônica desenvolvido com Laravel 12, Vue.js 3, Inertia.js e TailwindCSS. Gerencia clientes, orçamentos, ordens de serviço e controle financeiro.

## 📚 Índice

- [🚀 Tecnologias](#-tecnologias)
- [📋 Pré-requisitos](#-pré-requisitos)
- [🔧 Instalação](#-instalação)
- [🏗️ Estrutura do Projeto](#️-estrutura-do-projeto)
- [🧪 Testes](#-testes)
- [👥 Perfis de Usuário](#-perfis-de-usuário)
- [📝 Funcionalidades](#-funcionalidades)
- [🔐 Segurança](#-segurança)
- [📖 Documentação](#-documentação)
- [🤝 Contribuição](#-contribuição)

## 🚀 Tecnologias

- **Backend:** Laravel 12
- **Frontend:** Vue.js 3 + Inertia.js
- **CSS:** TailwindCSS
- **Banco de Dados:** MySQL 8+
- **Autenticação:** Laravel Breeze + Google OAuth
- **Autorização:** Spatie Laravel-permission
- **Testes:** Pest PHP
- **Servidor:** Caddy + PHP 8.4
- **Containerização:** Docker

## 📋 Pré-requisitos

- Docker
- Docker Compose
- Git

## 🔧 Instalação

Para instruções detalhadas sobre a instalação e configuração do ambiente Docker, consulte a [documentação Docker](./docs/docker/setup.md).

### Passos Básicos

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/eletronica-oriental.git
   cd eletronica-oriental
   ```

2. Configure o ambiente:
   ```bash
   cp .env.example .env
   ```

3. Inicie os containers:
   ```bash
   docker-compose up -d
   ```

4. Instale as dependências:
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

5. Configure o projeto:
   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan storage:link
   docker-compose exec app php artisan migrate --seed
   ```

6. Inicie o ambiente de desenvolvimento:
   ```bash
   docker-compose exec app npm run dev
   ```

**Acesse:** [http://localhost:8000](http://localhost:8000)

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

## 🏗️ Organização dos Serviços

### Estrutura por Perfil
O sistema possui uma organização clara dos serviços por perfil de usuário:

```
app/Services/
├── Common/ (4 serviços)
│   ├── ActivityLoggerService.php    # Log de atividades do sistema
│   ├── CacheService.php            # Cache do sistema
│   ├── ProfileService.php          # Gerenciamento de perfil
│   └── DashboardServiceFactory.php # Factory para dashboards
│
├── Proprietario/ (2 serviços)
│   ├── ClienteService.php          # CRUD de clientes
│   └── ConsertoService.php         # Gestão de consertos
│
├── Atendente/ (1 serviço)
│   └── AtendimentoService.php      # Gestão de atendimento
│
├── Relatorios/ (em desenvolvimento)
│   └── # Serviços de relatórios
│
└── Dashboards/ (1 serviço)
    └── ProprietarioDashboardService.php # Dashboard do proprietário
```

### Benefícios da Organização
- **Clareza:** Fácil identificação de qual serviço pertence a qual perfil
- **Manutenibilidade:** Organização lógica facilita manutenção
- **Escalabilidade:** Estrutura preparada para crescimento
- **Colaboração:** Desenvolvedores sabem onde encontrar código
- **Testes:** Organização facilita testes por perfil

## 🧪 Testes

### Status dos Testes
- **Total de Testes:** Em desenvolvimento
- **Cobertura:** Em implementação
- **Controllers:** Em desenvolvimento
- **Services:** Em desenvolvimento
- **Models:** Em desenvolvimento

### Executando Testes
```bash
# Todos os testes
docker-compose exec app php artisan test

# Testes específicos
docker-compose exec app php artisan test --filter="NomeDoTeste"

# Com coverage
docker-compose exec app php artisan test --coverage

# Com coverage mínimo (60%)
docker-compose exec app php artisan test --coverage --min=60
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

## 🔐 Segurança

- Autenticação via email/senha
- Autenticação via Google OAuth
- Autorização baseada em roles e permissions (Spatie)
- Proteção CSRF em todos os formulários
- Validação de dados via Form Requests
- Content Security Policy (CSP) configurada
- Headers de segurança automáticos via Caddy
- Rate limiting em rotas de autenticação
- Logs de atividade detalhados

## 📖 Documentação

### 🐳 Docker
- [Setup e Instalação](./docs/docker/setup.md) - Configuração inicial do ambiente Docker
- [Desenvolvimento](./docs/docker/development.md) - Comandos e scripts para desenvolvimento

### 🔗 Integrações
- [WhatsApp Business API](./docs/integrations/whatsapp.md) - Integração com WhatsApp Business
- [Sistemas de Pagamento](./docs/integrations/payment.md) - Integração com gateways de pagamento

### 🔧 Técnico
- [DTOs](./docs/technical/dtos.md) - Documentação dos Data Transfer Objects
- [API Mobile Preparation](./docs/technical/api-mobile-preparation.md) - Preparação para API mobile
- [Enums e Traits](./docs/technical/enums-and-traits.md) - Documentação dos enums e traits implementados
- [Testes](./docs/technical/testing.md) - Estratégia e padrões de testes
- [Dashboard Services](./docs/technical/dashboard-services.md) - Documentação dos serviços de dashboard
- [Controller Standardization](./docs/technical/controller-standardization.md) - Padronização de controllers com injeção de dependência
- [Routes Modularization](./docs/technical/routes-modularization.md) - Modularização de rotas por contexto

### 📚 Tutoriais
- [Configuração de Email](./docs/tutorials/email-setup.md) - Configuração de email para notificações
- [Configuração de WhatsApp](./docs/tutorials/whatsapp-setup.md) - Configuração do WhatsApp Business
- [Gestão de Clientes](./docs/tutorials/client-management.md) - Tutorial para gestão de clientes
- [Gestão de Ordens de Serviço](./docs/tutorials/service-orders.md) - Tutorial para gestão de ordens de serviço

### 📊 Estrutura do Banco
- [Estrutura do Banco de Dados](./docs/estrutura_banco.md) - Documentação completa da estrutura do banco de dados, relacionamentos e mudanças recentes

## 🤝 Contribuição

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Faça o Commit das suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Faça o Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### Padrões de Desenvolvimento
- **Testes:** Todos os novos recursos devem incluir testes
- **Documentação:** Atualize a documentação quando necessário
- **Cobertura:** Mantenha a cobertura de testes acima de 60%
- **Comentários:** Use comentários em português no código

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 🚀 Deploy em Produção

Por se tratar de um servidor compartilhado na Hostinger **NÃO suporta o uso do Docker**. O deploy é feito via GitHub Actions, que envia os arquivos para o servidor compartilhado da Hostinger usando SSH e executa os comandos necessários para rodar o Laravel em produção.

### Como funciona o deploy:
- O código é enviado automaticamente para o servidor Hostinger ao fazer push na branch `main`.
- O workflow do GitHub Actions instala dependências, compila os assets e faz upload dos arquivos via SSH.
- O `.env` de produção é gerado automaticamente com as variáveis dos secrets do GitHub.
- Comandos Artisan são executados remotamente para preparar o sistema.

**Atenção:**
- Docker é usado apenas para desenvolvimento local.
- Não é necessário rodar Docker no servidor Hostinger.
- Veja o arquivo `.github/workflows/cd.yml` para detalhes do pipeline.

### Exemplo de configuração do `.env` para produção:
```env
APP_NAME=Eletrônica Oriental
APP_ENV=production
APP_KEY= # Definido pelo workflow
APP_DEBUG=false
APP_URL=https://eletronica-oriental.com
LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@seudominio.com
MAIL_PASSWORD=sua_senha_smtp
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@seudominio.com
MAIL_FROM_NAME="Eletrônica Oriental"
```

---

## 🐳 Docker (apenas para desenvolvimento)

> **Atenção:** Docker e Docker Compose são usados apenas para desenvolvimento local. Em produção (Hostinger), NÃO utilize Docker.

Para instruções detalhadas sobre a instalação e configuração do ambiente Docker para desenvolvimento, consulte a [documentação Docker](./docs/docker/setup.md).
