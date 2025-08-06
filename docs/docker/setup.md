# 🐳 Setup Docker - Eletrônica Oriental

Guia completo para configurar o ambiente de desenvolvimento usando Docker.

## 📋 Pré-requisitos

- Docker
- Docker Compose
- Git

## 🚀 Instalação Rápida

### 1. Clone o Repositório
```bash
git clone https://github.com/seu-usuario/eletronica-oriental.git
cd eletronica-oriental
```

### 2. Configure o Ambiente
```bash
cp .env.example .env
```

### 3. Inicie os Containers
```bash
docker-compose up -d
```

### 4. Instale as Dependências
```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

### 5. Configure o Projeto
```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan storage:link
docker-compose exec app php artisan migrate --seed
```

### 6. Inicie o Ambiente de Desenvolvimento
```bash
docker-compose exec app npm run dev
```

**Acesse:** [http://localhost:8000](http://localhost:8000)

## 🏗️ Estrutura dos Containers

### Containers Disponíveis:

1. **app** (`eletronica-oriental-app`)
   - **Porta:** 8000:80
   - **Função:** Aplicação Laravel com Caddy
   - **Baseado em:** Dockerfile personalizado

2. **frontend** (`eletronica-oriental-frontend`)
   - **Porta:** 5173:5173
   - **Função:** Servidor de desenvolvimento Vite
   - **Baseado em:** Node.js 20 Alpine

3. **db** (`eletronica-oriental-db`)
   - **Função:** Banco de dados MySQL 8.0
   - **Volume:** Dados persistentes em `db_data`

4. **phpmyadmin** (`eletronica-oriental-phpmyadmin`)
   - **Porta:** 8080:80
   - **Função:** Interface web para MySQL
   - **Acesso:** http://localhost:8080

## ⚙️ Configuração Detalhada

### Variáveis de Ambiente

Crie um arquivo `.env` baseado no `.env.example`:

```env
APP_NAME="Eletrônica Oriental"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=eletronica_oriental
DB_USERNAME=root
DB_PASSWORD=password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Configuração do Docker Compose

O arquivo `docker-compose.yml` define:

```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: eletronica-oriental-app
    restart: unless-stopped
    working_dir: /var/www/html
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www/html:cached
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini:cached
      - ./docker/caddy/Caddyfile:/etc/caddy/Caddyfile:cached
      - .env.docker:/var/www/html/.env
    env_file:
      - .env.docker
    networks:
      - eletronica-oriental
    depends_on:
      db:
        condition: service_healthy

  frontend:
    image: node:20-alpine
    container_name: eletronica-oriental-frontend
    restart: unless-stopped
    working_dir: /app
    ports:
      - "5173:5173"
    volumes:
      - ./:/app:cached
      - /app/node_modules
    environment:
      - NODE_ENV=development
    command: sh -c "npm install --legacy-peer-deps && npm run dev -- --host 0.0.0.0"
    networks:
      - eletronica-oriental
    depends_on:
      - app

  db:
    image: mysql:8.0
    container_name: eletronica-oriental-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: eletronica_oriental
      MYSQL_ROOT_PASSWORD: password
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - db_data:/var/lib/mysql
      - ./docker/mysql:/docker-entrypoint-initdb.d
    networks:
      - eletronica-oriental
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-u", "root", "-p${DB_PASSWORD}"]
      interval: 10s
      timeout: 5s
      retries: 5

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: eletronica-oriental-phpmyadmin
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      PMA_USER: root
      PMA_PASSWORD: password
    ports:
      - "8080:80"
    networks:
      - eletronica-oriental
    depends_on:
      - db

networks:
  eletronica-oriental:
    driver: bridge
    name: eletronica-oriental-network

volumes:
  db_data:
    name: eletronica-oriental-db-data
```

## 🔧 Comandos Úteis

### Gerenciamento de Containers
```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Reiniciar containers
docker-compose restart

# Ver logs
docker-compose logs -f

# Ver logs de um container específico
docker-compose logs -f app
```

### Comandos Laravel
```bash
# Executar comandos Artisan
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:refresh --seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Criar um novo controller
docker-compose exec app php artisan make:controller NomeController

# Criar uma nova migration
docker-compose exec app php artisan make:migration create_nome_table
```

### Comandos Node.js
```bash
# Instalar dependências
docker-compose exec frontend npm install

# Executar em modo desenvolvimento
docker-compose exec frontend npm run dev

# Build para produção
docker-compose exec frontend npm run build
```

### Comandos de Banco de Dados
```bash
# Acessar MySQL
docker-compose exec db mysql -u root -ppassword eletronica_oriental

# Backup do banco
docker-compose exec db mysqldump -u root -ppassword eletronica_oriental > backup.sql

# Restaurar backup
docker-compose exec -T db mysql -u root -ppassword eletronica_oriental < backup.sql
```

## 🐛 Solução de Problemas

### Container não inicia
```bash
# Verificar logs
docker-compose logs app

# Reconstruir container
docker-compose up -d --build app
```

### Problemas de permissão
```bash
# Corrigir permissões
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Banco de dados não conecta
```bash
# Verificar se o MySQL está rodando
docker-compose ps db

# Verificar logs do MySQL
docker-compose logs db

# Reiniciar apenas o banco
docker-compose restart db
```

### Frontend não carrega
```bash
# Verificar se o Vite está rodando
docker-compose ps frontend

# Reiniciar frontend
docker-compose restart frontend

# Verificar logs
docker-compose logs frontend
```

## 📊 Acessos

- **Aplicação:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080
- **Frontend Dev:** http://localhost:5173

### Credenciais do Banco
- **Host:** db (dentro do Docker) ou localhost (fora)
- **Porta:** 3306
- **Database:** eletronica_oriental
- **Usuário:** root
- **Senha:** password

## 🔒 Segurança

### Para Desenvolvimento
- O ambiente está configurado para desenvolvimento local
- Não use estas configurações em produção
- O banco de dados não tem senha forte (apenas para dev)

### Para Produção
- Altere todas as senhas
- Configure HTTPS
- Use variáveis de ambiente seguras
- Configure backup do banco de dados

## 📝 Próximos Passos

Após a configuração inicial:

1. **Configure o usuário admin:**
   ```bash
   docker-compose exec app php artisan tinker
   # Criar usuário admin
   ```

2. **Configure as permissões:**
   ```bash
   docker-compose exec app php artisan db:seed --class=RoleSeeder
   ```

3. **Teste o sistema:**
   - Acesse http://localhost:8000
   - Faça login com as credenciais criadas
   - Teste as funcionalidades básicas

4. **Configure o ambiente de desenvolvimento:**
   - Configure seu editor/IDE
   - Configure debuggers se necessário
   - Configure linting e formatação

---

**💡 Dica:** Use o script `docker-dev.sh` para comandos rápidos de desenvolvimento. 
