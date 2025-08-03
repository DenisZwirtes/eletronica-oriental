# Eletrônica Oriental - Sistema de Gestão

Sistema de gestão para eletrônica desenvolvido com Laravel 12.0, Vue.js 3.4.0, Inertia.js e TailwindCSS. Gerencia consertos, ordens de serviço, clientes e controle de estoque.

## 📚 Índice

- [🚀 Tecnologias](#-tecnologias)
- [📋 Pré-requisitos](#-pré-requisitos)
- [🔧 Instalação](#-instalação)
- [🏗️ Estrutura do Projeto](#️-estrutura-do-projeto)
- [🧪 Testes](#-testes)
- [📧 Email e WhatsApp](#-email-e-whatsapp)
- [👥 Perfis de Usuário](#-perfis-de-usuário)
- [📝 Funcionalidades](#-funcionalidades)
- [🔐 Segurança](#-segurança)
- [📖 Documentação](#-documentação)
- [🤝 Contribuição](#-contribuição)

## 🚀 Tecnologias

- **Backend:** Laravel 12.0
- **Frontend:** Vue.js 3.4.0 + Inertia.js 2.0
- **CSS:** TailwindCSS 3.2.1
- **Banco de Dados:** MySQL 8+
- **Autenticação:** Laravel Breeze + Google OAuth
- **Autorização:** Spatie Laravel-permission 6.21
- **Testes:** Pest PHP 3.0
- **Servidor:** FrankenPHP (Caddy + PHP 8.4)
- **Containerização:** Docker
- **Relatórios:** DomPDF + Excel
- **QR Code:** Simple QR Code

## 📋 Pré-requisitos

- Docker
- Docker Compose
- Git

## 🔧 Instalação

### Ambiente Docker (Recomendado)

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/eletronica-oriental.git
   cd eletronica-oriental
   ```

2. Inicie o ambiente de desenvolvimento:
   ```bash
   ./docker-dev.sh start
   ```

3. Acesse a aplicação:
   - **Aplicação:** [http://localhost:8000](http://localhost:8000)
   - **PHPMyAdmin:** [http://localhost:8080](http://localhost:8080)
   - **Frontend:** [http://localhost:5173](http://localhost:5173)

### Comandos Úteis

```bash
# Iniciar ambiente
./docker-dev.sh start

# Parar ambiente
./docker-dev.sh stop

# Reiniciar ambiente
./docker-dev.sh restart

# Ver logs
./docker-dev.sh logs

# Executar comando no container
./docker-dev.sh exec 'php artisan migrate'

# Acessar shell do container
./docker-dev.sh shell

# Limpar tudo
./docker-dev.sh clean

# Ver ajuda
./docker-dev.sh help
```

### Credenciais de Acesso

- **Email:** proprietario@eletronica.com
- **Senha:** password

## 🏗️ Estrutura do Projeto

### Principais Diretórios
```
├── app
│   ├── Http
│   │   ├── Controllers      # Controladores por função
│   │   ├── Middleware       # Middlewares da aplicação
│   │   └── Requests        # Form Requests para validação
│   ├── Models              # Modelos do Eloquent
│   └── Services           # Camada de serviços organizada por perfil
│       ├── Common/         # Serviços comuns a todos os perfis
│       ├── Admin/          # Serviços específicos do administrador
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
├── Common/ (8 serviços)
│   ├── ActivityLoggerService.php    # Log de atividades do sistema
│   ├── GoogleAuthService.php        # Autenticação Google
│   ├── LogService.php              # Logs gerais do sistema
│   ├── ProfileService.php          # Gerenciamento de perfil
│   ├── RateLimiterService.php      # Controle de taxa de requisições
│   ├── RedirectService.php         # Redirecionamentos
│   ├── CacheService.php            # Cache do sistema
│   └── DashboardServiceFactory.php # Factory para dashboards
│
├── Proprietario/ (8 serviços)
│   ├── ClienteService.php          # CRUD de clientes
│   ├── OrdemServicoService.php     # Gestão de ordens de serviço
│   ├── OrcamentoService.php        # Gestão de orçamentos
│   ├── ConsertoService.php         # Execução de consertos
│   ├── DiagnosticoService.php      # Diagnósticos técnicos
│   ├── GarantiaService.php         # Controle de garantias
│   ├── RelatorioService.php        # Relatórios gerais
│   └── ConfiguracaoService.php     # Configurações do sistema
│
├── Relatorios/ (3 serviços)
│   ├── GeradorDadosRelatorioService.php # Geração de dados para relatórios
│   ├── RelatorioService.php        # Relatórios gerais
│   └── ExportacaoService.php       # Exportação de dados
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
- **Total de Testes:** Implementação em andamento
- **Cobertura:** Meta de 60% de cobertura de código
- **Padrão:** Pest PHP com mensagens em português

### Executando Testes
```bash
# Todos os testes
docker compose exec app php artisan test

# Testes específicos
docker compose exec app php artisan test --filter="NomeDoTeste"

# Com coverage
docker compose exec app php artisan test --coverage

# Com coverage mínimo (60%)
docker compose exec app php artisan test --coverage --min=60
```

## 📧 Email e WhatsApp

### Ambiente de Email

- **Desenvolvimento/Testes:**  
  Utilize o MailHog (já configurado no docker-compose) para capturar todos os emails enviados pelo sistema.
  - Interface: [http://localhost:8025](http://localhost:8025)
  - Nenhum email é enviado de verdade.
  - Configure seu `.env` assim:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    ```

- **Produção:**  
  Configure o `.env` de produção com as credenciais SMTP:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.seudominio.com
    MAIL_PORT=587
    MAIL_USERNAME=seu_email@seudominio.com
    MAIL_PASSWORD=sua_senha_smtp
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=contato@seudominio.com
    MAIL_FROM_NAME="Eletrônica Oriental"
    ```

## 👥 Perfil de Usuário

O sistema possui um único usuário:
- **Proprietário**: Acesso completo ao sistema para gerenciar clientes, ordens de serviço, orçamentos e relatórios

## 📝 Funcionalidades

### Módulo Principal (Proprietário)
- Gestão de clientes (CRUD)
- Gestão de ordens de serviço (CRUD)
- Gestão de orçamentos (CRUD)
- Execução de consertos
- Diagnósticos técnicos
- Controle de garantias
- Atendimento ao cliente
- Geração de relatórios em PDF/Excel
- Configurações do sistema

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
- [n8n](./docs/integrations/n8n.md) - Integração com n8n para automações

### 🔧 Técnico
- [DTOs](./docs/technical/dtos.md) - Documentação dos Data Transfer Objects
- [API Mobile Preparation](./docs/technical/api-mobile-preparation.md) - Preparação para API mobile
- [Controller Standardization](./docs/technical/controller-standardization.md) - Padronização de controllers com injeção de dependência
- [Routes Modularization](./docs/technical/routes-modularization.md) - Modularização de rotas por contexto

### 📚 Tutoriais
- [Email e WhatsApp Setup](./docs/tutorials/email-whatsapp-setup.md) - Configuração de email e WhatsApp
- [Workflow de Email no n8n](./docs/tutorials/email-workflow.md) - Tutorial prático para criar workflows

### 📊 Estrutura do Banco
- [Estrutura do Banco de Dados](./docs/estrutura_banco.md) - Documentação completa da estrutura do banco

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

---

## 🚀 Deploy em Produção

O sistema está preparado para deploy em produção com as seguintes configurações:

### Exemplo de configuração do `.env` para produção:
```env
APP_NAME="Eletrônica Oriental"
APP_ENV=production
APP_KEY= # Definido pelo workflow
APP_DEBUG=false
APP_URL=https://seudominio.com
LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
MAIL_MAILER=smtp
MAIL_HOST=smtp.seudominio.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@seudominio.com
MAIL_PASSWORD=sua_senha_smtp
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@seudominio.com
MAIL_FROM_NAME="Eletrônica Oriental"
```
