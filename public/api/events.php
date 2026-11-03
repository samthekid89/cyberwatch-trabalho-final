<?php
/**
 * public/api/events.php — listar eventos
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: GET | Acesso: autenticado
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php, auth.php, Event.php; iniciar sessão.
 *  2. require_method(['GET']); require_login().
 *  3. Ler e validar query: severity, event_type, q, from, to, sort, order, page, per_page.
 *  4. Chamar Event::list(...) e devolver items + pagination (ver docs/api.md).
 */
