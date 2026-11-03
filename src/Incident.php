<?php
/**
 * src/Incident.php — lógica de incidentes
 * Responsável: Samuel
 *
 * TODO (funções ou métodos de classe):
 *  1. create($title, $attack_type, $severity, $source_ip)
 *       - estado inicial 'open'; devolver o incidente criado.
 *  2. list($filters, $page, $per_page)
 *       - filtros: status, severity; ordenar por created_at desc; devolver items + total.
 *  3. find($id)
 *       - incidente + utilizador atribuído (JOIN com users) + lista de eventos
 *         associados (JOIN incident_events/events) ordenados por timestamp (timeline).
 *  4. update($id, $new_status, $notes, $user_id)
 *       - validar transição: open → investigating → resolved (resto = INVALID_TRANSITION);
 *       - ao passar a investigating: assigned_to = $user_id;
 *       - ao passar a resolved: resolved_at = agora;
 *       - atualizar notas se enviadas.
 *  5. find_active_by_source($source_ip, $attack_type)
 *       - procura incidente open/investigating da mesma origem e tipo (evita duplicados).
 *  6. attach_event($incident_id, $event_id)
 *       - INSERT em incident_events (ignorar se já existir).
 *  7. Regras de severidade do incidente (ex.: depende do tipo de ataque e do nº de eventos).
 *  8. Gerar título automático (ex.: "Brute force a partir de <ip>").
 */
