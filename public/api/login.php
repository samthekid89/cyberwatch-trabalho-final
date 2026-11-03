<?php
/**
 * public/api/login.php — iniciar sessão
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: POST | Acesso: público
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php e auth.php; iniciar sessão segura.
 *  2. require_method(['POST']); ler o corpo JSON (username, password).
 *  3. Validar que ambos existem e têm tamanho razoável (400/422 se não).
 *  4. Chamar attempt_login(); se falhar → 401 INVALID_CREDENTIALS (mensagem genérica).
 *  5. Sucesso → devolver user (id, username, role) + csrf_token.
 */
