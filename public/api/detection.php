<?php
/**
 * public/api/detection.php — regras de deteção
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: GET (listar), POST (atualizar) | Acesso: GET: autenticado | POST: admin
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php, auth.php, DetectionRules.php; iniciar sessão; require_login().
 *  2. GET  → DetectionRules::all().
 *  3. POST com ?id → require_role('admin'); verify_csrf(); validar enabled/threshold/time_window_seconds;
 *     DetectionRules::update(); devolver a regra atualizada (404 se o id não existir).
 */
