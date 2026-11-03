<?php
/**
 * public/api/incidents.php — listar, ver detalhe e atualizar incidentes
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: GET (lista/detalhe), POST (atualizar) | Acesso: autenticado
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php, auth.php, Incident.php; iniciar sessão; require_login().
 *  2. GET sem id  → validar filtros status/severity/page/per_page; Incident::list().
 *  3. GET com ?id → Incident::find(); 404 NOT_FOUND se não existir.
 *  4. POST com ?id → verify_csrf(); ler JSON {status?, notes?}; validar valores;
 *     Incident::update(); 422 INVALID_TRANSITION se a transição não for permitida.
 *  5. Qualquer outro método → 405.
 */
