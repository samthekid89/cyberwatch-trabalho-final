# Checklist de segurança (backend)

Marcar cada ponto quando estiver implementado e testado.

## Autenticação e sessões
- [ ] Passwords guardadas com `password_hash()` e verificadas com `password_verify()`
- [ ] `session_regenerate_id(true)` após login
- [ ] Cookie de sessão com `HttpOnly` e `SameSite=Lax` (e `Secure` se houver HTTPS)
- [ ] Logout destrói a sessão e o cookie
- [ ] Mensagem de login igual para "utilizador inexistente" e "password errada"
- [ ] Limitar tentativas de login (ex.: bloqueio temporário após N falhas)

## Autorização
- [ ] Todos os endpoints (exceto login) exigem sessão
- [ ] Endpoints de admin verificam `role` no servidor (nunca confiar no frontend)

## Base de dados
- [ ] Apenas prepared statements PDO, sem concatenar input em SQL
- [ ] `PDO::ATTR_EMULATE_PREPARES = false` e `ERRMODE_EXCEPTION`
- [ ] `ORDER BY` / nomes de colunas só através de whitelist
- [ ] Utilizador MySQL da app com privilégios mínimos (não usar `root`)

## Pedidos
- [ ] Validar método HTTP em cada endpoint (405)
- [ ] Token CSRF validado em todos os `POST`
- [ ] Validar tipo, tamanho e valores permitidos de todos os parâmetros
- [ ] Limites de paginação (`per_page` máx. 100)

## Respostas e erros
- [ ] Erros internos devolvem mensagem genérica; detalhe vai para `logs/`
- [ ] `display_errors` desligado fora de desenvolvimento
- [ ] Output no frontend escapado (usar `textContent`, nunca `innerHTML` com dados da API)

## Repositório
- [ ] `config/config.php` e logs não estão no Git
- [ ] Seed sem passwords em texto simples
