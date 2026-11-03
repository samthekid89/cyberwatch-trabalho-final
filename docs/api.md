# Contrato da API — CyberWatch

Documento partilhado entre Pedro (consome) e Samuel (implementa).
Alterações a este ficheiro devem ser combinadas entre os dois.

## Convenções gerais

- Base: caminhos relativos a partir de `public/` → `api/<ficheiro>.php`
- Formato: JSON (`Content-Type: application/json; charset=utf-8`)
- Autenticação: sessão PHP (cookie). No `fetch` usar `credentials: 'same-origin'`.
- CSRF: o `csrf_token` vem em `login.php` e `me.php`. Enviar em todos os `POST` no header `X-CSRF-Token`.
- Datas: `YYYY-MM-DD HH:MM:SS` (hora de Lisboa) em string.
- Nomes de campos em `snake_case`, iguais às colunas da BD.

### Resposta de sucesso

```json
{ "ok": true, "data": { } }
```

### Resposta de erro

```json
{ "ok": false, "error": { "code": "VALIDATION_ERROR", "message": "Texto legível em português" } }
```

### Códigos HTTP

| Código | Quando |
|--------|--------|
| 200 | Sucesso |
| 400 | Pedido inválido (JSON mal formado, parâmetros inválidos) |
| 401 | Não autenticado |
| 403 | Sem permissão (perfil errado) ou CSRF inválido |
| 404 | Recurso não existe |
| 405 | Método não permitido |
| 422 | Validação falhou (ex.: transição de estado inválida) |
| 500 | Erro interno (mensagem genérica, detalhe só no log) |

### Códigos de erro (`error.code`)

`UNAUTHENTICATED`, `FORBIDDEN`, `CSRF_INVALID`, `VALIDATION_ERROR`, `NOT_FOUND`,
`METHOD_NOT_ALLOWED`, `INVALID_CREDENTIALS`, `INVALID_TRANSITION`, `SERVER_ERROR`

## Endpoints

| Método | Ficheiro | Perfil | Descrição |
|--------|----------|--------|-----------|
| POST | `api/login.php` | público | Iniciar sessão |
| POST | `api/logout.php` | autenticado | Terminar sessão |
| GET | `api/me.php` | autenticado | Utilizador atual + csrf_token |
| GET | `api/stats.php` | autenticado | KPIs e séries do dashboard |
| GET | `api/events.php` | autenticado | Listar eventos (filtros, paginação) |
| GET | `api/incidents.php` | autenticado | Listar incidentes, ou detalhe com `?id=` |
| POST | `api/incidents.php?id=N` | autenticado | Atualizar estado e/ou notas |
| GET | `api/detection.php` | autenticado | Listar regras |
| POST | `api/detection.php?id=N` | admin | Atualizar regra |
| POST | `api/simulate.php` | autenticado | Simular ataque |

---

### POST `api/login.php`

Pedido:
```json
{ "username": "samuel", "password": "..." }
```
Resposta 200:
```json
{ "ok": true, "data": { "user": { "id": 1, "username": "samuel", "role": "admin" }, "csrf_token": "abc123..." } }
```
Erro 401 → `INVALID_CREDENTIALS` (mensagem igual para utilizador inexistente e password errada).

### GET `api/me.php`

Resposta 200: igual ao login. Sem sessão → 401 `UNAUTHENTICATED`.

### GET `api/stats.php`

```json
{
  "ok": true,
  "data": {
    "kpis": {
      "events_24h": 128,
      "open_incidents": 4,
      "critical_alerts": 2,
      "avg_resolution_minutes": 47
    },
    "events_per_hour": [ { "hour": "2026-10-01 14:00:00", "count": 12 } ],
    "events_by_attack_type": [ { "attack_type": "brute_force", "count": 60 } ],
    "incidents_by_status": [ { "status": "open", "count": 4 } ],
    "latest_incidents": [ { "id": 8, "title": "...", "severity": "high", "status": "open", "created_at": "..." } ]
  }
}
```

### GET `api/events.php`

Query (todos opcionais): `severity`, `event_type`, `q` (pesquisa em IP/descrição),
`from`, `to` (datas), `sort` (`timestamp`|`severity`), `order` (`asc`|`desc`), `page` (def. 1), `per_page` (def. 20, máx. 100).

```json
{
  "ok": true,
  "data": {
    "items": [
      { "id": 31, "timestamp": "2026-10-01 14:02:11", "source_ip": "203.0.113.45",
        "event_type": "login_failed", "severity": "medium", "description": "Falha de autenticação para o utilizador admin" }
    ],
    "pagination": { "page": 1, "per_page": 20, "total": 128, "total_pages": 7 }
  }
}
```

### GET `api/incidents.php`

Query: `status`, `severity`, `page`, `per_page`.

```json
{
  "ok": true,
  "data": {
    "items": [
      { "id": 8, "title": "Brute force a partir de 203.0.113.45", "attack_type": "brute_force",
        "severity": "high", "status": "open", "source_ip": "203.0.113.45",
        "assigned_to": null, "created_at": "2026-10-01 14:03:00", "updated_at": "2026-10-01 14:03:00" }
    ],
    "pagination": { "page": 1, "per_page": 20, "total": 8, "total_pages": 1 }
  }
}
```

### GET `api/incidents.php?id=8` (detalhe)

```json
{
  "ok": true,
  "data": {
    "incident": {
      "id": 8, "title": "...", "attack_type": "brute_force", "severity": "high", "status": "open",
      "source_ip": "203.0.113.45", "assigned_to": null, "assigned_username": null, "notes": "",
      "created_at": "...", "updated_at": "...", "resolved_at": null
    },
    "events": [ { "id": 31, "timestamp": "...", "source_ip": "...", "event_type": "login_failed", "severity": "medium", "description": "..." } ]
  }
}
```

### POST `api/incidents.php?id=8`

Pedido (enviar um ou ambos):
```json
{ "status": "investigating", "notes": "A analisar os logs do servidor." }
```
Transições válidas: `open → investigating → resolved`. Qualquer outra → 422 `INVALID_TRANSITION`.
Ao passar a `investigating`, `assigned_to` fica o utilizador atual. Ao passar a `resolved`, preencher `resolved_at`.
Resposta 200: o `incident` atualizado (mesmo formato do detalhe).

### GET `api/detection.php`

```json
{
  "ok": true,
  "data": { "items": [
    { "id": 1, "name": "Brute force de login", "attack_type": "brute_force", "threshold": 5, "time_window_seconds": 60, "enabled": 1 }
  ] }
}
```

### POST `api/detection.php?id=1` (admin)

```json
{ "enabled": 1, "threshold": 8, "time_window_seconds": 120 }
```
Validar: `threshold` 1–1000, `time_window_seconds` 10–86400, `enabled` 0/1. Resposta: regra atualizada.

### POST `api/simulate.php`

```json
{ "attack_type": "brute_force", "intensity": 10 }
```
`intensity` = número de eventos a gerar (1–50, def. 10).
```json
{ "ok": true, "data": { "events_created": 10, "incidents_created": [ { "id": 9, "title": "...", "severity": "high" } ], "incidents_updated": [] } }
```
