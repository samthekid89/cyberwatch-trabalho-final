<?php
/**
 * src/DetectionRules.php — regras de deteção e motor de avaliação
 * Responsável: Samuel
 *
 * TODO (funções ou métodos de classe):
 *  1. all()  → lista de regras.
 *  2. find_by_attack_type($attack_type) → regra ativa ou null.
 *  3. update($id, $enabled, $threshold, $time_window_seconds)
 *       - validar intervalos (threshold 1–1000, janela 10–86400, enabled 0/1).
 *  4. evaluate($event)   ← O CORAÇÃO DO SOC
 *       a) descobrir o attack_type a partir do event_type;
 *       b) obter a regra ativa; se não existir ou estiver desativada → terminar;
 *       c) contar eventos da mesma origem e tipo dentro da janela de tempo;
 *       d) se contagem >= threshold:
 *            - se já existe incidente ativo para (source_ip, attack_type) → ligar o evento a ele;
 *            - senão → criar incidente e ligar todos os eventos da janela;
 *       e) usar TRANSAÇÃO PDO para não deixar dados a meio;
 *       f) devolver {incident, created: bool} ou null.
 *  5. Pensar nos casos limite: eventos repetidos, regra alterada a meio, incidente já resolvido
 *     (um novo ataque depois de resolvido deve abrir novo incidente).
 */
