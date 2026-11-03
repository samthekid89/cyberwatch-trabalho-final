# Fluxo de Git

Cada um é avaliado pelos seus commits, por isso o histórico tem de ser claro e individual.

## Branches

- `main`: sempre estável, só recebe merges que funcionam
- `samuel/<tema>`: ex. `samuel/auth`, `samuel/deteccao`
- `pedro/<tema>`: ex. `pedro/dashboard`, `pedro/login-ui`

## Regras

1. Nunca trabalhar diretamente em `main`.
2. Commits pequenos e frequentes (idealmente um por funcionalidade/passo).
3. Mensagens em português no formato `tipo: descrição curta`
   - `feat: adiciona login com password_verify`
   - `fix: corrige filtro de severidade nos eventos`
   - `docs: atualiza contrato de /api/incidents`
   - `refactor:` · `style:` · `chore:`
4. Antes de fazer merge para `main`: `git pull origin main`, resolver conflitos, testar.
5. Cada um só mexe na sua zona (ver README). Se for preciso mexer na do outro, avisar.
6. Nunca fazer commit de `config/config.php`, passwords ou ficheiros de log.

## Rotina diária

```
git checkout main && git pull
git checkout -b <nome>/<tema>      # ou continuar a branch existente
# ... trabalhar, git add, git commit ...
git push -u origin <nome>/<tema>
```
