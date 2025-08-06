# 🛠️ Desenvolvimento Docker - Eletrônica Oriental

Guia completo para desenvolvimento usando Docker.

## 🚀 Comandos Rápidos

### Script de Desenvolvimento
Use o script `docker-dev.sh` para comandos rápidos:

```bash
# Dar permissão de execução
chmod +x docker-dev.sh

# Ver comandos disponíveis
./docker-dev.sh

# Comandos principais
./docker-dev.sh up          # Iniciar containers
./docker-dev.sh down        # Parar containers
./docker-dev.sh restart     # Reiniciar containers
./docker-dev.sh logs        # Ver logs
./docker-dev.sh shell       # Acessar shell do app
./docker-dev.sh db          # Acessar MySQL
./docker-dev.sh fresh       # Fresh install
```

## 🔧 Comandos de Desenvolvimento

### Laravel Artisan
```bash
# Comandos básicos
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:refresh --seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Criar arquivos
docker-compose exec app php artisan make:controller NomeController
docker-compose exec app php artisan make:model NomeModel
docker-compose exec app php artisan make:migration create_nome_table
docker-compose exec app php artisan make:seeder NomeSeeder
docker-compose exec app php artisan make:request NomeRequest
docker-compose exec app php artisan make:service NomeService

# Testes
docker-compose exec app php artisan test
docker-compose exec app php artisan test --coverage
docker-compose exec app php artisan test --filter="NomeDoTeste"

# Tinker
docker-compose exec app php artisan tinker
```

### Node.js e Frontend
```bash
# Instalar dependências
docker-compose exec frontend npm install
docker-compose exec frontend npm install --legacy-peer-deps

# Desenvolvimento
docker-compose exec frontend npm run dev
docker-compose exec frontend npm run build
docker-compose exec frontend npm run build --watch

# Linting
docker-compose exec frontend npm run lint
docker-compose exec frontend npm run lint:fix
```

### Banco de Dados
```bash
# Acessar MySQL
docker-compose exec db mysql -u root -ppassword eletronica_oriental

# Backup
docker-compose exec db mysqldump -u root -ppassword eletronica_oriental > backup.sql

# Restaurar
docker-compose exec -T db mysql -u root -ppassword eletronica_oriental < backup.sql

# Ver tabelas
docker-compose exec db mysql -u root -ppassword -e "USE eletronica_oriental; SHOW TABLES;"

# Ver estrutura de uma tabela
docker-compose exec db mysql -u root -ppassword -e "USE eletronica_oriental; DESCRIBE nome_tabela;"
```

## 🐛 Debugging

### Logs
```bash
# Ver todos os logs
docker-compose logs -f

# Logs específicos
docker-compose logs -f app
docker-compose logs -f frontend
docker-compose logs -f db

# Logs do Laravel
docker-compose exec app tail -f storage/logs/laravel.log
```

### Debugging PHP
```bash
# Acessar shell do container
docker-compose exec app bash

# Verificar configuração PHP
docker-compose exec app php -i

# Verificar extensões PHP
docker-compose exec app php -m

# Verificar versão
docker-compose exec app php -v
```

### Debugging Node.js
```bash
# Acessar shell do frontend
docker-compose exec frontend sh

# Verificar versão Node
docker-compose exec frontend node -v

# Verificar versão npm
docker-compose exec frontend npm -v
```

## 🔍 Troubleshooting

### Problemas Comuns

#### 1. Container não inicia
```bash
# Verificar logs
docker-compose logs app

# Reconstruir container
docker-compose up -d --build app

# Verificar se há conflitos de porta
docker ps
netstat -tulpn | grep :8000
```

#### 2. Banco de dados não conecta
```bash
# Verificar se MySQL está rodando
docker-compose ps db

# Verificar logs do MySQL
docker-compose logs db

# Reiniciar apenas o banco
docker-compose restart db

# Verificar conectividade
docker-compose exec app php artisan tinker
# Testar: DB::connection()->getPdo();
```

#### 3. Frontend não carrega
```bash
# Verificar se Vite está rodando
docker-compose ps frontend

# Verificar logs
docker-compose logs frontend

# Reiniciar frontend
docker-compose restart frontend

# Verificar se porta 5173 está livre
netstat -tulpn | grep :5173
```

#### 4. Problemas de permissão
```bash
# Corrigir permissões
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache

# Verificar permissões
docker-compose exec app ls -la storage/
docker-compose exec app ls -la bootstrap/cache/
```

#### 5. Cache não limpa
```bash
# Limpar todos os caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Limpar cache do composer
docker-compose exec app composer clear-cache

# Limpar cache do npm
docker-compose exec frontend npm cache clean --force
```

## 🧪 Testes

### Executar Testes
```bash
# Todos os testes
docker-compose exec app php artisan test

# Testes específicos
docker-compose exec app php artisan test --filter="NomeDoTeste"

# Com coverage
docker-compose exec app php artisan test --coverage

# Com coverage mínimo
docker-compose exec app php artisan test --coverage --min=60

# Testes de feature
docker-compose exec app php artisan test tests/Feature/

# Testes unitários
docker-compose exec app php artisan test tests/Unit/
```

### Debugging de Testes
```bash
# Ver logs detalhados
docker-compose exec app php artisan test --verbose

# Parar no primeiro erro
docker-compose exec app php artisan test --stop-on-failure

# Executar apenas um teste
docker-compose exec app php artisan test --filter="test_nome_do_metodo"
```

## 📊 Monitoramento

### Status dos Containers
```bash
# Ver status
docker-compose ps

# Ver uso de recursos
docker stats

# Ver volumes
docker volume ls

# Ver networks
docker network ls
```

### Performance
```bash
# Ver uso de CPU e memória
docker stats eletronica-oriental-app
docker stats eletronica-oriental-frontend
docker stats eletronica-oriental-db

# Ver logs de performance
docker-compose exec app tail -f storage/logs/laravel.log | grep -i "slow"
```

## 🔧 Configurações Avançadas

### PHP Configuration
O arquivo `docker/php/local.ini` contém configurações específicas para desenvolvimento:

```ini
; Configurações de memória
memory_limit = 512M
max_execution_time = 300

; Configurações de upload
upload_max_filesize = 100M
post_max_size = 100M

; Configurações de erro
display_errors = On
display_startup_errors = On
log_errors = On
error_log = /var/log/php_errors.log

; Configurações de sessão
session.gc_maxlifetime = 7200
session.cookie_lifetime = 7200
```

### Caddy Configuration
O arquivo `docker/caddy/Caddyfile` configura o servidor web:

```caddyfile
:80 {
    root * /var/www/html/public
    php_fastcgi app:9000
    file_server
    encode gzip
}
```

### MySQL Configuration
Configurações do MySQL no `docker-compose.yml`:

```yaml
db:
  image: mysql:8.0
  environment:
    MYSQL_DATABASE: eletronica_oriental
    MYSQL_ROOT_PASSWORD: password
  volumes:
    - db_data:/var/lib/mysql
    - ./docker/mysql:/docker-entrypoint-initdb.d
```

## 🚀 Workflow de Desenvolvimento

### 1. Iniciar Desenvolvimento
```bash
# Iniciar ambiente
./docker-dev.sh up

# Verificar status
./docker-dev.sh status
```

### 2. Desenvolvimento Diário
```bash
# Ver logs em tempo real
./docker-dev.sh logs

# Acessar shell para comandos
./docker-dev.sh shell

# Executar testes
docker-compose exec app php artisan test
```

### 3. Finalizar Desenvolvimento
```bash
# Parar containers
./docker-dev.sh down

# Ou manter rodando para próximo uso
# (containers ficam em background)
```

## 📝 Dicas de Desenvolvimento

### 1. Hot Reload
- O Vite está configurado para hot reload
- Alterações em arquivos Vue.js são refletidas automaticamente
- Para PHP, pode ser necessário limpar cache

### 2. Debugging
- Use `dd()` ou `dump()` para debug
- Logs ficam em `storage/logs/laravel.log`
- Use `docker-compose logs -f` para ver logs em tempo real

### 3. Performance
- Use `docker stats` para monitorar recursos
- Configure Xdebug se necessário para debugging avançado
- Use cache do Laravel em desenvolvimento

### 4. Segurança
- Nunca use senhas fracas em produção
- Configure HTTPS em produção
- Use variáveis de ambiente para configurações sensíveis

---

**💡 Dica:** Mantenha o script `docker-dev.sh` atualizado com seus comandos mais usados. 
