# 📋 Próximos Passos - Eletrônica Oriental

Este documento contém um checklist organizado dos próximos passos para o desenvolvimento do sistema. Use como guia sempre que retomar o projeto.

---

## 🎯 **Status Atual do Projeto**

### ✅ **Funcionalidades Implementadas:**
- [x] Sistema de autenticação (login/logout)
- [x] Dashboard com estatísticas
- [x] CRUD de Clientes
- [x] CRUD de Ordens de Serviço
- [x] Geração de PDF para ordens de serviço
- [x] Preview de PDF antes de salvar
- [x] Listagem de ordens com filtros
- [x] Sistema de roles e permissões
- [x] Estrutura de banco de dados completa

### 🔧 **Tecnologias Utilizadas:**
- Laravel 12 + Vue.js 3 + Inertia.js
- TailwindCSS para estilização
- DomPDF para geração de PDFs
- MySQL 8.0 como banco de dados
- Docker para desenvolvimento

---

## 📋 **Checklist de Próximos Passos**

### 🧪 **1. Testes Unitários e de Integração**

#### **1.1 Testes de Controllers**
- [ ] **OrdemServicoController**
  - [ ] Teste do método `index()` - listar ordens
  - [ ] Teste do método `store()` - criar ordem
  - [ ] Teste do método `show()` - visualizar ordem
  - [ ] Teste do método `update()` - atualizar ordem
  - [ ] Teste do método `destroy()` - excluir ordem
  - [ ] Teste do método `imprimir()` - gerar PDF
  - [ ] Teste do método `preview()` - preview PDF

- [ ] **ClienteController**
  - [ ] Teste do método `index()` - listar clientes
  - [ ] Teste do método `store()` - criar cliente
  - [ ] Teste do método `show()` - visualizar cliente
  - [ ] Teste do método `update()` - atualizar cliente
  - [ ] Teste do método `destroy()` - excluir cliente

- [ ] **DashboardController**
  - [ ] Teste do método `index()` - estatísticas do dashboard

#### **1.2 Testes de Services**
- [ ] **OrdemServicoService**
  - [ ] Teste do método `listar()`
  - [ ] Teste do método `criar()`
  - [ ] Teste do método `atualizar()`
  - [ ] Teste do método `excluir()`
  - [ ] Teste do método `buscarPorId()`

- [ ] **ClienteService**
  - [ ] Teste do método `listar()`
  - [ ] Teste do método `criar()`
  - [ ] Teste do método `atualizar()`
  - [ ] Teste do método `excluir()`
  - [ ] Teste do método `buscarPorId()`

#### **1.3 Testes de Models**
- [ ] **OrdemServico Model**
  - [ ] Teste de relacionamentos (cliente, tecnico)
  - [ ] Teste de scopes (pendente, em_andamento, etc.)
  - [ ] Teste de mutators/accessors
  - [ ] Teste de validações

- [ ] **Cliente Model**
  - [ ] Teste de relacionamentos (ordens, orçamentos)
  - [ ] Teste de scopes (ativo, inativo)
  - [ ] Teste de mutators/accessors

#### **1.4 Testes de DTOs**
- [ ] **OrdemServicoDTO**
  - [ ] Teste de `fromRequest()`
  - [ ] Teste de `fromModel()`
  - [ ] Teste de `toArray()`
  - [ ] Teste de `toResponseArray()`

- [ ] **ClienteDTO**
  - [ ] Teste de `fromRequest()`
  - [ ] Teste de `fromModel()`
  - [ ] Teste de `toArray()`

#### **1.5 Testes de Form Requests**
- [ ] **OrdemServicoRequest**
  - [ ] Teste de validações
  - [ ] Teste de autorização
  - [ ] Teste de mensagens personalizadas

- [ ] **ClienteRequest**
  - [ ] Teste de validações
  - [ ] Teste de autorização

#### **1.6 Testes de Enums**
- [ ] **OrdemServicoStatus**
  - [ ] Teste de labels
  - [ ] Teste de cores
  - [ ] Teste de métodos utilitários

- [ ] **UserRole**
  - [ ] Teste de labels
  - [ ] Teste de permissões
  - [ ] Teste de métodos utilitários

#### **1.7 Testes de Traits**
- [ ] **HasAuditLog**
  - [ ] Teste de log de atividades
  - [ ] Teste de rastreamento de mudanças

- [ ] **HasStatusManagement**
  - [ ] Teste de mudança de status
  - [ ] Teste de validações de status

### 📚 **2. Documentação**

#### **2.1 Documentação Técnica**
- [ ] **API Documentation**
  - [ ] Documentar endpoints de ordens de serviço
  - [ ] Documentar endpoints de clientes
  - [ ] Documentar endpoints de dashboard
  - [ ] Usar Swagger/OpenAPI

- [ ] **Documentação de Código**
  - [ ] Adicionar PHPDoc em todos os métodos
  - [ ] Documentar parâmetros e retornos
  - [ ] Documentar exceções lançadas

- [ ] **Documentação de Arquitetura**
  - [ ] Diagrama de classes
  - [ ] Diagrama de banco de dados
  - [ ] Fluxo de autenticação
  - [ ] Fluxo de criação de ordem

#### **2.2 Documentação de Usuário**
- [ ] **Manual do Usuário**
  - [ ] Como criar uma ordem de serviço
  - [ ] Como imprimir ordens
  - [ ] Como gerenciar clientes
  - [ ] Como usar o dashboard

- [ ] **Tutoriais**
  - [ ] Tutorial de primeiro acesso
  - [ ] Tutorial de criação de ordem
  - [ ] Tutorial de impressão

### 🎨 **3. Melhorias de UX/UI**

#### **3.1 Componentes Vue**
- [ ] **Componentes Reutilizáveis**
  - [ ] Componente de formulário de ordem
  - [ ] Componente de tabela de ordens
  - [ ] Componente de modal de confirmação
  - [ ] Componente de loading

- [ ] **Melhorias de Interface**
  - [ ] Adicionar SweetAlert para mensagens
  - [ ] Implementar loading states
  - [ ] Adicionar tooltips informativos
  - [ ] Melhorar responsividade mobile

#### **3.2 Funcionalidades de UX**
- [ ] **Validação em Tempo Real**
  - [ ] Validação de formulários no frontend
  - [ ] Feedback visual de erros
  - [ ] Auto-complete de campos

- [ ] **Filtros e Busca**
  - [ ] Filtro por status na listagem
  - [ ] Busca por número de ordem
  - [ ] Busca por cliente
  - [ ] Ordenação por data/valor

### 🔧 **4. Funcionalidades Pendentes**

#### **4.1 Módulo de Orçamentos**
- [ ] **CRUD de Orçamentos**
  - [ ] Criar OrcamentoController
  - [ ] Criar OrcamentoService
  - [ ] Criar OrcamentoDTO
  - [ ] Criar OrcamentoRequest
  - [ ] Criar páginas Vue

- [ ] **Funcionalidades de Orçamento**
  - [ ] Aprovação/rejeição de orçamentos
  - [ ] Conversão de orçamento para ordem
  - [ ] Validade de orçamentos
  - [ ] Histórico de orçamentos

#### **4.2 Módulo de Técnicos**
- [ ] **Gestão de Técnicos**
  - [ ] CRUD de técnicos
  - [ ] Atribuição de ordens
  - [ ] Dashboard do técnico
  - [ ] Relatórios de produtividade

#### **4.3 Módulo de Relatórios**
- [ ] **Relatórios Financeiros**
  - [ ] Relatório de vendas por período
  - [ ] Relatório de lucros
  - [ ] Relatório de clientes
  - [ ] Exportação para Excel/PDF

- [ ] **Relatórios Operacionais**
  - [ ] Relatório de ordens por status
  - [ ] Relatório de tempo médio de reparo
  - [ ] Relatório de garantias
  - [ ] Relatório de peças utilizadas

### 🔐 **5. Segurança e Performance**

#### **5.1 Segurança (CRÍTICO - Prioridade Máxima)**

- [ ] **Rate Limiting**
  - [ ] Implementar rate limiting em rotas de autenticação (login, register)
  - [ ] Rate limiting em rotas de API públicas
  - [ ] Configurar limites por IP e por usuário
  - [ ] Implementar throttling para endpoints sensíveis
  - [ ] Configurar cache para rate limiting (Redis)

- [ ] **Proteção contra SQL Injection**
  - [ ] Revisar todas as queries Eloquent
  - [ ] Implementar prepared statements onde necessário
  - [ ] Validar parâmetros de busca e filtros
  - [ ] Sanitizar inputs de formulários
  - [ ] Implementar escape de caracteres especiais
  - [ ] Revisar scopes e relacionamentos

- [ ] **Proteção contra XSS (Cross-Site Scripting)**
  - [ ] Implementar escape automático no Vue.js
  - [ ] Sanitizar dados antes de exibir no frontend
  - [ ] Configurar Content Security Policy (CSP)
  - [ ] Validar e sanitizar inputs de rich text
  - [ ] Implementar whitelist de tags HTML permitidas
  - [ ] Revisar todos os campos de texto livre

- [ ] **Validação e Sanitização de Dados**
  - [ ] Revisar todas as validações nos Form Requests
  - [ ] Implementar sanitização automática de inputs
  - [ ] Validar tipos de dados (inteiros, strings, etc.)
  - [ ] Implementar validação de tamanho máximo de campos
  - [ ] Sanitizar uploads de arquivos
  - [ ] Validar formatos de email, telefone, CPF/CNPJ

- [ ] **Autenticação e Autorização**
  - [ ] Implementar rate limiting por sessão
  - [ ] Logs de segurança detalhados
  - [ ] Auditoria de ações sensíveis
  - [ ] Implementar timeout de sessão
  - [ ] Backup automático de dados
  - [ ] Monitoramento de tentativas de login

- [ ] **Headers de Segurança**
  - [ ] Configurar X-Frame-Options
  - [ ] Implementar X-Content-Type-Options
  - [ ] Configurar X-XSS-Protection
  - [ ] Implementar Strict-Transport-Security (HSTS)
  - [ ] Configurar Referrer-Policy
  - [ ] Implementar Content-Security-Policy

- [ ] **Validação de Uploads**
  - [ ] Validar tipos de arquivo permitidos
  - [ ] Implementar verificação de vírus
  - [ ] Limitar tamanho de uploads
  - [ ] Sanitizar nomes de arquivos
  - [ ] Implementar armazenamento seguro

- [ ] **Auditoria de Segurança**
  - [ ] Executar análise estática de código (PHPStan)
  - [ ] Verificar vulnerabilidades nas dependências (composer audit)
  - [ ] Testar endpoints com ferramentas de segurança
  - [ ] Implementar logging de tentativas de ataque
  - [ ] Configurar alertas de segurança
  - [ ] Revisar permissões de arquivos e diretórios

#### **5.2 Performance**
- [ ] **Otimizações de Banco**
  - [ ] Índices para consultas frequentes
  - [ ] Otimização de queries
  - [ ] Paginação de resultados
  - [ ] Cache de consultas

- [ ] **Otimizações de Frontend**
  - [ ] Lazy loading de componentes
  - [ ] Otimização de imagens
  - [ ] Minificação de assets
  - [ ] Cache de dados

### 🚀 **6. Deploy e Produção**

#### **6.1 Configuração de Produção**
- [ ] **Ambiente de Produção**
  - [ ] Configurar servidor de produção
  - [ ] Configurar banco de dados
  - [ ] Configurar SSL/HTTPS
  - [ ] Configurar backup automático

- [ ] **CI/CD**
  - [ ] Configurar GitHub Actions
  - [ ] Testes automatizados
  - [ ] Deploy automático
  - [ ] Monitoramento

#### **6.2 Monitoramento**
- [ ] **Logs e Monitoramento**
  - [ ] Configurar logs de aplicação
  - [ ] Monitoramento de performance
  - [ ] Alertas de erro
  - [ ] Métricas de uso

### 📱 **7. Funcionalidades Avançadas**

#### **7.1 Integrações**
- [ ] **WhatsApp Business API**
  - [ ] Notificações automáticas
  - [ ] Status de ordens
  - [ ] Lembretes de garantia

- [ ] **Sistemas de Pagamento**
  - [ ] Integração com PIX
  - [ ] Integração com cartão
  - [ ] Controle de pagamentos

#### **7.2 Mobile**
- [ ] **API Mobile**
  - [ ] Endpoints para app mobile
  - [ ] Autenticação via token
  - [ ] Sincronização offline

- [ ] **PWA (Progressive Web App)**
  - [ ] Instalação como app
  - [ ] Funcionamento offline
  - [ ] Notificações push

### 🧹 **8. Refatoração e Limpeza**

#### **8.1 Código**
- [ ] **Refatoração**
  - [ ] Remover código duplicado
  - [ ] Melhorar estrutura de classes
  - [ ] Otimizar queries
  - [ ] Padronizar nomenclatura

- [ ] **Limpeza**
  - [ ] Remover arquivos não utilizados
  - [ ] Limpar logs antigos
  - [ ] Otimizar dependências
  - [ ] Revisar configurações

---

## 🎯 **Prioridades Sugeridas**

### **Alta Prioridade (Próximas 2 semanas):**
1. **🔐 Melhorias de Segurança** (CRÍTICO)
   - Implementar rate limiting em rotas públicas
   - Reforçar proteção contra SQL Injection
   - Implementar proteção contra XSS
   - Validar e sanitizar todos os inputs
2. Testes unitários dos controllers principais
3. Implementar SweetAlert para mensagens
4. Adicionar filtros na listagem de ordens
5. Documentar API básica

### **Média Prioridade (Próximo mês):**
1. Módulo de orçamentos
2. Relatórios básicos
3. Melhorias de UX
4. Testes de integração

### **Baixa Prioridade (Próximos meses):**
1. Integrações externas
2. App mobile
3. Funcionalidades avançadas
4. Otimizações de performance

---

## 📝 **Notas Importantes**

### **Para Retomar o Projeto:**
1. Verificar se os containers Docker estão rodando
2. Executar `composer install` e `npm install`
3. Verificar se as migrations estão atualizadas
4. Verificar se os seeders foram executados
5. Acessar http://localhost:8000

### **Comandos Úteis:**
```bash
# Iniciar containers
docker-compose up -d

# Executar testes
docker-compose exec app php artisan test

# Ver logs
docker-compose logs app

# Acessar banco
docker-compose exec app php artisan tinker

# Verificar vulnerabilidades de segurança
composer audit

# Analisar código com PHPStan
./vendor/bin/phpstan analyse

# Verificar dependências desatualizadas
composer outdated
```

### **🔐 Implementação de Segurança (Exemplos Práticos):**

#### **Rate Limiting:**
```php
// Em routes/web.php
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    // Rotas protegidas com limite de 60 requests por minuto
});

// Para rotas de autenticação
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});
```

#### **Proteção XSS no Vue.js:**
```javascript
// Em componentes Vue
const sanitizeHtml = (html) => {
    return DOMPurify.sanitize(html, {
        ALLOWED_TAGS: ['b', 'i', 'em', 'strong', 'a'],
        ALLOWED_ATTR: ['href']
    });
};

// Usar v-html com sanitização
<div v-html="sanitizeHtml(content)"></div>
```

#### **Validação de Inputs:**
```php
// Em Form Requests
public function rules(): array
{
    return [
        'nome' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
        'email' => 'required|email|max:255',
        'telefone' => 'required|string|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
        'cpf_cnpj' => 'required|string|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$|^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
    ];
}
```

#### **Headers de Segurança:**
```php
// Em App\Http\Middleware\SecurityHeaders.php
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    
    return $response;
}
```

---

**Última atualização:** 13/08/2025  
**Versão do projeto:** 1.0.1  
**Próxima revisão:** 20/08/2025  
**Última atualização de segurança:** 13/08/2025
