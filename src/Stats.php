<?php
/**
 * src/Stats.php — dados agregados para o dashboard
 * Responsável: Samuel
 *
 * TODO (cada função = 1 query com prepared statement quando houver parâmetros):
 *  1. kpis()
 *       - events_24h: nº de eventos nas últimas 24 h;
 *       - open_incidents: incidentes com estado open (ou open + investigating — decidir e documentar);
 *       - critical_alerts: incidentes ativos com severidade critical;
 *       - avg_resolution_minutes: média de TIMESTAMPDIFF(MINUTE, created_at, resolved_at)
 *         dos incidentes resolvidos (tratar o caso de não haver nenhum → 0 ou null).
 *  2. events_per_hour()      → contagem por hora nas últimas 24 h (GROUP BY hora).
 *                              Atenção a horas sem eventos (preencher com 0 no PHP ou no JS).
 *  3. events_by_attack_type() → contagem por tipo (mapear event_type → attack_type).
 *  4. incidents_by_status()   → contagem por estado (devolver os 3 estados, mesmo com 0).
 *  5. latest_incidents($n = 5) → últimos n incidentes.
 *  6. all() → junta tudo no formato descrito em docs/api.md (GET api/stats.php).
 */
