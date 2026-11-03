<?php
/**
 * public/api/me.php — utilizador atual
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: GET | Acesso: autenticado
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php e auth.php; iniciar sessão.
 *  2. require_method(['GET']); require_login() (401 se não houver sessão).
 *  3. Devolver user (id, username, role) + csrf_token.
 *  O frontend usa este endpoint para saber se há sessão e qual o perfil.
 */
