<?php
/**
 * src/Event.php — eventos/logs de segurança
 * Responsável: Samuel
 *
 * TODO (funções ou métodos de classe):
 *  1. create($timestamp, $source_ip, $event_type, $severity, $description)
 *       - validar valores contra as constantes; INSERT com prepared statement; devolver o id.
 *  2. list($filters, $page, $per_page)
 *       - filtros: severity, event_type, q (LIKE em source_ip/description), from, to;
 *       - ordenação por whitelist (timestamp|severity) e order asc|desc;
 *       - WHERE construído dinamicamente MAS só com parâmetros ligados (placeholders);
 *       - devolver items + total (para a paginação).
 *  3. count_recent($source_ip, $event_type, $window_seconds)
 *       - nº de eventos daquela origem/tipo na janela de tempo (usado pela deteção).
 *  4. find_recent($source_ip, $event_type, $window_seconds)
 *       - devolve os eventos da janela (para os ligar ao incidente).
 *  5. Mapa event_type → attack_type (login_failed→brute_force, port_scan_probe→port_scan,
 *     suspicious_login→suspicious_login).
 */
