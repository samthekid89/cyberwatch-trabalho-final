/*
  public/js/api.js — wrapper de fetch para a API
  Responsável: Pedro

  TODO:
   1. Função base apiFetch(url, opções) com credentials: 'same-origin' e Content-Type JSON.
   2. Usar caminhos RELATIVOS ('api/incidents.php').
   3. Guardar o csrf_token (vem de login/me) e enviá-lo no header X-CSRF-Token nos POST.
   4. Interpretar o formato {ok, data} / {ok:false, error} de docs/api.md e lançar erro útil.
   5. Se a resposta for 401 → redirecionar para login.html.
   6. Funções por endpoint: login(), logout(), me(), getStats(), getEvents(filtros),
      getIncidents(filtros), getIncident(id), updateIncident(id, dados), getRules(),
      updateRule(id, dados), simulate(tipo, intensidade).
   7. (Enquanto o backend não existe) opção de usar dados mock no formato de docs/api.md.
*/
