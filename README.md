# CyberWatch — esqueleto do projeto (PAP)

Simulação de um SOC (Security Operations Center) em aplicação web.
Stack: HTML/CSS/JS (vanilla) + PHP (PDO) + MySQL. Chart.js no dashboard.

> Todos os ficheiros contêm apenas comentários `TODO` com a lógica a implementar.
> Nenhum código funcional foi escrito: o código é feito por nós.

## Divisão de tarefas

| Quem | Pasta | O que faz |
|------|-------|-----------|
| **Pedro (frontend)** | `public/` (exceto `public/api/`) | HTML, CSS, JS, fetch, Chart.js, UX |
| **Samuel (backend)** | `public/api/`, `src/`, `database/`, `config/` | PHP, MySQL, auth, deteção, incidentes |

## Estrutura

```
cyberwatch/
├── .gitignore
├── README.md
├── config/
│   └── config.example.php      # modelo; copiar para config.php (ignorado pelo Git)
├── database/
│   ├── schema.sql              # tabelas
│   └── seed.sql                # dados iniciais / exemplo
├── docs/
│   ├── api.md                  # CONTRATO da API (Pedro e Samuel seguem isto)
│   ├── git-workflow.md         # branches e commits
│   └── seguranca.md            # checklist de segurança
├── logs/                       # logs de erro PHP (ignorados pelo Git)
├── src/                        # lógica PHP (FORA do alcance direto do browser)
│   ├── db.php                  # ligação PDO
│   ├── helpers.php             # JSON, validação, sessões, CSRF
│   ├── auth.php                # login, logout, utilizador atual
│   ├── Event.php               # eventos/logs
│   ├── Incident.php            # incidentes
│   ├── DetectionRules.php      # regras e motor de deteção
│   ├── AttackSimulator.php     # gera eventos de ataque simulados
│   └── Stats.php               # KPIs e séries do dashboard
└── public/                     # DOCUMENT ROOT
    ├── index.html
    ├── login.html
    ├── dashboard.html
    ├── events.html
    ├── incidents.html
    ├── incident.html           # detalhe (?id=)
    ├── rules.html
    ├── simulator.html
    ├── api/                    # endpoints finos: validam pedido e chamam src/
    │   ├── login.php  logout.php  me.php
    │   ├── events.php  incidents.php  detection.php
    │   ├── simulate.php  stats.php
    ├── css/styles.css
    ├── js/                     # api.js, auth.js, ui.js + um ficheiro por página
    └── assets/logo/
```

**Porquê `api/` dentro de `public/`?** O browser tem de conseguir fazer `fetch` aos
endpoints, por isso eles ficam no document root. A lógica sensível (`src/`, `config/`,
`database/`, `logs/`) fica fora, e os endpoints só fazem `require` de `../../src/...`.

## Como arrancar

1. Copiar `config/config.example.php` para `config/config.php` e preencher as credenciais locais.
2. Criar a base de dados `cyberwatch` (utf8mb4) e importar `database/schema.sql` e depois `database/seed.sql`.
3. Servidor (XAMPP/WAMP): apontar o document root para a pasta `public/` (VirtualHost).
   Alternativa rápida: pôr o projeto em `htdocs/cyberwatch/` e abrir `http://localhost/cyberwatch/public/`.
4. No frontend usar **caminhos relativos** (`api/incidents.php`, nunca `/api/...`), para funcionar nas duas formas.
5. Abrir `login.html` e entrar com o utilizador do seed.

## Constantes do domínio (usar exatamente estes valores)

| Conceito | Valores |
|----------|---------|
| Tipos de ataque (`attack_type`) | `brute_force`, `port_scan`, `suspicious_login` |
| Tipos de evento (`event_type`) | `login_failed`, `port_scan_probe`, `suspicious_login` |
| Severidade (`severity`) | `low`, `medium`, `high`, `critical` |
| Estado do incidente (`status`) | `open`, `investigating`, `resolved` |
| Perfis (`role`) | `admin`, `analista` |

Etiquetas na interface: Aberto / Em investigação / Resolvido; Baixa / Média / Alta / Crítica.

## Ecrãs (MVP: 7)

Login · Dashboard · Eventos/Logs · Lista de Incidentes · Detalhe do Incidente · Regras de Deteção (admin) · Simulador de Ataques

## Ordem sugerida: backend (Samuel)

1. `config/config.example.php` → `config/config.php`
2. `database/schema.sql` + `database/seed.sql`
3. `src/db.php` (PDO) e `src/helpers.php`
4. `src/auth.php` + `public/api/login.php`, `logout.php`, `me.php`
5. `src/Event.php` + `public/api/events.php`
6. `src/Incident.php` + `public/api/incidents.php`
7. `src/DetectionRules.php` + `public/api/detection.php` (**precisa de eventos primeiro**)
8. `src/AttackSimulator.php` + `public/api/simulate.php`
9. `src/Stats.php` + `public/api/stats.php`
10. Rever `docs/seguranca.md`

## Ordem sugerida: frontend (Pedro)

1. `css/styles.css` (variáveis, tipografia) e `js/ui.js` (layout, toasts, badges)
2. `js/api.js` e `js/auth.js` + `login.html`
3. Páginas com **dados mock** (formato de `docs/api.md`) enquanto a API não existe
4. Trocar mocks por `fetch` real, uma página de cada vez, à medida que o backend fica pronto
5. Dashboard com Chart.js

## Marcos de integração

- **M1** Login completo (frontend + backend)
- **M2** Eventos e incidentes (listar, filtrar, detalhe, mudar estado)
- **M3** Regras + simulador + deteção automática
- **M4** Dashboard com dados reais
- **M5** Testes, segurança, documentação, polimento

## Regras do projeto

- Contrato da API em `docs/api.md`: se mudar, avisar o outro **antes**.
- Fluxo de Git em `docs/git-workflow.md`.
- Nunca fazer commit de `config/config.php`.
