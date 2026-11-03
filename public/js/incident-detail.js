/*
  public/js/incident-detail.js — página de detalhe do incidente
  Responsável: Pedro

  TODO:
   1. Ler o id do URL (URLSearchParams); chamar api.getIncident(id).
   2. Renderizar resumo e timeline de eventos.
   3. Botão da próxima transição de estado → api.updateIncident(id, {status}).
   4. Guardar notas → api.updateIncident(id, {notes}).
   5. Tratar erro 422 (transição inválida) e 404 (incidente inexistente).
*/
