<?php
/**
 * public/api/simulate.php — simular um ataque
 * Responsável: Samuel | Contrato: docs/api.md
 * Métodos: POST | Acesso: autenticado
 *
 * Os endpoints são FINOS: validam o pedido e delegam a lógica para src/.
 * Caminhos: require_once __DIR__ . '/../../src/ficheiro.php';
 *
 * TODO:
 *  1. Carregar helpers.php, db.php, auth.php, Event.php, Incident.php, DetectionRules.php,
 *     AttackSimulator.php; iniciar sessão.
 *  2. require_method(['POST']); require_login(); verify_csrf().
 *  3. Ler JSON {attack_type, intensity}; validar attack_type (whitelist) e intensity (1–50).
 *  4. AttackSimulator::simulate() e devolver resumo (events_created, incidents_created, incidents_updated).
 */
