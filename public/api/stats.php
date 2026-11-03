<?php
/**
 * public/api/stats.php — KPIs e séries do dashboard
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: GET | Acesso: autenticado
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php, auth.php, Stats.php; iniciar sessão.
 *  2. require_method(['GET']); require_login().
 *  3. Devolver Stats::all() no formato de docs/api.md.
 */
