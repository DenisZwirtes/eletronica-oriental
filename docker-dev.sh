#!/bin/bash

# Script de desenvolvimento para Eletrônica Oriental
# Baseado no projeto sistema-educacional-joineed

set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Função para imprimir mensagens coloridas
print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}================================${NC}"
    echo -e "${BLUE}  Eletrônica Oriental - Dev${NC}"
    echo -e "${BLUE}================================${NC}"
}

# Função para verificar se Docker está instalado
check_docker() {
    if ! command -v docker &> /dev/null; then
        print_error "Docker não está instalado. Por favor, instale o Docker primeiro."
        exit 1
    fi

    if ! docker compose version &> /dev/null; then
        print_error "Docker Compose não está disponível. Por favor, instale o Docker Compose primeiro."
        exit 1
    fi
}

# Função para iniciar o ambiente
start() {
    print_header
    print_message "Iniciando ambiente de desenvolvimento..."

    check_docker

    # Gerar chave da aplicação se não existir
    if [ ! -f .env ]; then
        print_warning "Arquivo .env não encontrado. Copiando .env.example..."
        cp .env.example .env
    fi

        # Iniciar containers
    print_message "Iniciando containers..."
    docker compose up -d

    # Aguardar banco estar pronto
    print_message "Aguardando banco de dados..."
    sleep 10

    # Gerar chave da aplicação
    print_message "Gerando chave da aplicação..."
    docker compose exec app php artisan key:generate || true

    # Executar migrações
    print_message "Executando migrações..."
    docker compose exec app php artisan migrate --force

    # Executar seeders
    print_message "Executando seeders..."
    docker compose exec app php artisan db:seed --force

    # Instalar dependências Node.js
    print_message "Instalando dependências Node.js..."
    docker compose exec frontend npm install

    print_message "Ambiente iniciado com sucesso!"
    print_message "Acesse: http://localhost:8000"
    print_message "PHPMyAdmin: http://localhost:8080"
    print_message "Frontend: http://localhost:5173"
}

# Função para parar o ambiente
stop() {
    print_header
    print_message "Parando ambiente de desenvolvimento..."
    docker compose down
    print_message "Ambiente parado!"
}

# Função para reiniciar o ambiente
restart() {
    print_header
    print_message "Reiniciando ambiente de desenvolvimento..."
    docker compose down
    docker compose up -d
    print_message "Ambiente reiniciado!"
}

# Função para logs
logs() {
    print_header
    print_message "Exibindo logs..."
    docker compose logs -f
}

# Função para executar comandos no container
exec() {
    if [ -z "$1" ]; then
        print_error "Especifique um comando para executar"
        echo "Exemplo: ./docker-dev.sh exec 'php artisan migrate'"
        exit 1
    fi

    print_header
    print_message "Executando comando: $1"
    docker compose exec app $1
}

# Função para acessar shell do container
shell() {
    print_header
    print_message "Acessando shell do container..."
    docker compose exec app bash
}

# Função para limpar tudo
clean() {
    print_header
    print_warning "Esta ação irá remover todos os containers, volumes e imagens!"
    read -p "Tem certeza? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_message "Limpando ambiente..."
        docker compose down -v --rmi all
        docker system prune -f
        print_message "Ambiente limpo!"
    else
        print_message "Operação cancelada."
    fi
}

# Função para mostrar ajuda
help() {
    print_header
    echo "Comandos disponíveis:"
    echo "  start   - Iniciar ambiente de desenvolvimento"
    echo "  stop    - Parar ambiente de desenvolvimento"
    echo "  restart - Reiniciar ambiente de desenvolvimento"
    echo "  logs    - Exibir logs dos containers"
    echo "  exec    - Executar comando no container (ex: 'php artisan migrate')"
    echo "  shell   - Acessar shell do container"
    echo "  clean   - Limpar tudo (containers, volumes, imagens)"
    echo "  help    - Mostrar esta ajuda"
    echo ""
    echo "Exemplos:"
    echo "  ./docker-dev.sh start"
    echo "  ./docker-dev.sh exec 'php artisan make:controller ClienteController'"
    echo "  ./docker-dev.sh shell"
}

# Verificar argumentos
case "${1:-help}" in
    start)
        start
        ;;
    stop)
        stop
        ;;
    restart)
        restart
        ;;
    logs)
        logs
        ;;
    exec)
        shift
        exec "$@"
        ;;
    shell)
        shell
        ;;
    clean)
        clean
        ;;
    help|*)
        help
        ;;
esac
