<?php
/**
 * src/AttackSimulator.php — gera eventos de ataque simulados
 * Responsável: Samuel
 *
 * Sem isto o SOC não tem o que analisar: o simulador é a "fonte de logs" da aplicação.
 *
 * TODO:
 *  1. simulate($attack_type, $intensity)
 *       - validar attack_type e intensity (1–50);
 *       - escolher um IP de origem aleatório de 203.0.113.0/24 ou 198.51.100.0/24;
 *       - gerar $intensity eventos com timestamps próximos de "agora" (poucos segundos entre si);
 *       - para cada evento: Event::create(...) e a seguir DetectionRules::evaluate(evento);
 *       - devolver resumo: eventos criados + incidentes criados/atualizados.
 *  2. Perfil de cada ataque (event_type, severidade, texto da descrição):
 *       - brute_force   → login_failed, severidade média, descrições de falha de autenticação
 *                         em contas comuns (admin, root, ...), mesmo IP;
 *       - port_scan        → port_scan_probe, severidade baixa/média, portas diferentes em sequência;
 *       - suspicious_login → suspicious_login, severidade alta, logins com sucesso do mesmo
 *                            utilizador a partir de IPs diferentes ou a horas invulgares.
 *  3. (Opcional) gerar também eventos de "ruído" legítimos de severidade baixa.
 *  4. (Opcional) intensidade abaixo do limiar NÃO deve criar incidente — útil para demonstrar a regra.
 */
