# Padrões Implementados no Projeto

Este documento descreve os principais padrões de arquitetura e boas práticas adotados no projeto **Eletrônica Oriental** para garantir organização, escalabilidade e facilidade de manutenção.

---

## 1. DTOs (Data Transfer Objects)

- **Local:** `app/DTOs/`
- **Objetivo:** Transferir dados de forma estruturada entre camadas (Controller, Service, Model).
- **Vantagens:**
  - Tipagem forte e validação de estrutura
  - Facilita testes e manutenção
- **Exemplo:**
```php
$dto = ClienteDTO::fromRequest($request);
$service->criar($dto);
```

---

## 2. Enums

- **Local:** `app/Enums/`
- **Objetivo:** Definir valores fixos para status, tipos e papéis (roles), com métodos auxiliares.
- **Vantagens:**
  - Evita strings "mágicas" espalhadas pelo código
  - Métodos utilitários para label, cor, permissões, etc.
- **Exemplo:**
```php
$status = OrcamentoStatus::APROVADO;
$label = $status->label();
```

---

## 3. Traits

- **Local:** `app/Traits/`
- **Objetivo:** Compartilhar funcionalidades entre modelos (ex: logging, status, roles).
- **Vantagens:**
  - Reutilização de código
  - Centralização de lógica comum
- **Exemplo:**
```php
use HasAuditLog, HasStatusManagement;
```

---

## 4. Form Requests

- **Local:** `app/Http/Requests/`
- **Objetivo:** Centralizar validação e autorização de dados de entrada.
- **Vantagens:**
  - Validação desacoplada do controller
  - Mensagens personalizadas
- **Exemplo:**
```php
public function store(ClienteRequest $request) { ... }
```

---

## 5. Services

- **Local:** `app/Services/`
- **Objetivo:** Encapsular regras de negócio, separando lógica do controller.
- **Vantagens:**
  - Facilita testes e manutenção
  - Controllers mais enxutos
- **Exemplo:**
```php
$cliente = $this->service->criar($dto);
```

---

## 6. Factories para Testes

- **Local:** `database/factories/`
- **Objetivo:** Gerar dados fake realistas para testes e seeders.
- **Vantagens:**
  - Testes automatizados mais robustos
  - Seeders dinâmicos
- **Exemplo:**
```php
Cliente::factory()->count(10)->create();
```

---

## Recomendações Gerais
- Sempre utilize os DTOs para entrada/saída de dados em Services e Controllers.
- Prefira Enums para status, tipos e papéis.
- Centralize validações em Form Requests.
- Use Traits para lógica comum entre modelos.
- Utilize Factories para popular o banco em testes.

---

**Dúvidas ou sugestões? Consulte este documento ou abra uma issue!**
