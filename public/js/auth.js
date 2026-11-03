/*
  public/js/auth.js — login, logout e proteção de páginas
  Responsável: Pedro

  TODO:
   1. login.html: ligar o formulário a api.login(); mostrar erro; redirecionar para dashboard.html.
   2. Nas restantes páginas: chamar api.me() ao carregar; sem sessão → login.html.
   3. Guardar o utilizador atual (username, role) para o ui.js mostrar no menu.
   4. Botão 'Sair' → api.logout() → login.html.
   5. Esconder item 'Regras de Deteção' do menu se role !== 'admin'.
*/
