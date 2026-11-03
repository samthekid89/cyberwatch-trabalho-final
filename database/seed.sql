-- database/seed.sql — dados iniciais e de exemplo
--
-- TODO:
--  1. users: criar 1 admin e 1 analista.
--     ATENÇÃO: não escrever passwords em texto simples. Gerar o hash com
--     password_hash() (ex.: pequeno script PHP de uso único ou `php -r` na linha de comandos)
--     e colar apenas o hash aqui.
--  2. detection_rules: 3 regras (uma por attack_type), por exemplo:
--       brute_force    → threshold 5,  janela 60 s
--       port_scan        → threshold 10, janela 30 s
--       suspicious_login → threshold 3,  janela 300 s
--  3. events: ~30 eventos de exemplo com timestamps recentes, IPs de documentação
--     (203.0.113.x e 198.51.100.x, nunca IPs reais) e mistura de tipos/severidades.
--  4. incidents: ~8 incidentes de exemplo com estados variados (open/investigating/resolved).
--     Para os resolved, preencher resolved_at (para o KPI de tempo médio).
--  5. incident_events: ligar alguns eventos aos incidentes de exemplo.
--  6. Confirmar que o seed corre sem erros depois do schema.sql.


-- database/seed.sql — dados de demonstração do CyberWatch
-- Importar DEPOIS do schema.sql. Todos os IPs são de documentação (fictícios).
-- As datas são relativas a "agora", para o dashboard mostrar sempre dados recentes.

USE cyberwatch;

-- 1) Utilizadores (passwords guardadas apenas como hash)
INSERT INTO users (id, username, password_hash, role) VALUES
(1, 'samuel',   '$2y$10$qrS5KfnBLh5Iqm7UaJHMoOdyrqnIAR1kJIXXDicTROQLP9I3z5BZm', 'admin'),
(2, 'analista', '$2y$10$qrS5KfnBLh5Iqm7UaJHMoOdyrqnIAR1kJIXXDicTROQLP9I3z5BZm', 'analista');

-- 2) Regras de deteção (uma por tipo de ataque)
INSERT INTO detection_rules (id, name, attack_type, threshold, time_window_seconds, enabled) VALUES
(1, 'Brute force de login', 'brute_force',      5,  60,  1),
(2, 'Port scan',            'port_scan',        10, 30,  1),
(3, 'Login suspeito',       'suspicious_login', 3,  300, 1);

-- 3) Eventos (logs)
INSERT INTO events (id, `timestamp`, source_ip, event_type, severity, description) VALUES
-- Brute force de 203.0.113.45 (incidente 1)
(1,  NOW() - INTERVAL 3000 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador admin'),
(2,  NOW() - INTERVAL 2990 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador root'),
(3,  NOW() - INTERVAL 2980 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador admin'),
(4,  NOW() - INTERVAL 2970 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador test'),
(5,  NOW() - INTERVAL 2960 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador administrator'),
(6,  NOW() - INTERVAL 2950 SECOND, '203.0.113.45', 'login_failed', 'medium', 'Falha de autenticação para o utilizador admin'),
-- Port scan de 198.51.100.23 (incidente 2)
(7,  NOW() - INTERVAL 10800 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 21 (FTP)'),
(8,  NOW() - INTERVAL 10797 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 22 (SSH)'),
(9,  NOW() - INTERVAL 10794 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 23 (Telnet)'),
(10, NOW() - INTERVAL 10791 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 25 (SMTP)'),
(11, NOW() - INTERVAL 10788 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 53 (DNS)'),
(12, NOW() - INTERVAL 10785 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 80 (HTTP)'),
(13, NOW() - INTERVAL 10782 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 110 (POP3)'),
(14, NOW() - INTERVAL 10779 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 443 (HTTPS)'),
(15, NOW() - INTERVAL 10776 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 3306 (MySQL)'),
(16, NOW() - INTERVAL 10773 SECOND, '198.51.100.23', 'port_scan_probe', 'low', 'Ligação à porta 3389 (RDP)'),
-- Login suspeito de 203.0.113.77 (incidente 3)
(17, NOW() - INTERVAL 18000 SECOND, '203.0.113.77', 'suspicious_login', 'high', 'Login com sucesso de um país invulgar para o utilizador analista'),
(18, NOW() - INTERVAL 17940 SECOND, '203.0.113.77', 'suspicious_login', 'high', 'Segundo login com sucesso a partir de um IP diferente'),
(19, NOW() - INTERVAL 17880 SECOND, '203.0.113.77', 'suspicious_login', 'high', 'Login fora do horário habitual'),
-- Eventos soltos, sem incidente (ruído normal)
(20, NOW() - INTERVAL 7200 SECOND, '192.0.2.10', 'login_failed',    'low', 'Falha de autenticação isolada para o utilizador analista'),
(21, NOW() - INTERVAL 5400 SECOND, '192.0.2.55', 'port_scan_probe', 'low', 'Ligação isolada à porta 8080'),
-- Brute force de 203.0.113.99 (incidente 4)
(22, NOW() - INTERVAL 1200 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador admin'),
(23, NOW() - INTERVAL 1195 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador admin'),
(24, NOW() - INTERVAL 1190 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador root'),
(25, NOW() - INTERVAL 1185 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador admin'),
(26, NOW() - INTERVAL 1180 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador guest'),
(27, NOW() - INTERVAL 1175 SECOND, '203.0.113.99', 'login_failed', 'high', 'Falha de autenticação para o utilizador admin');

-- 4) Incidentes (estados variados)
INSERT INTO incidents (id, title, attack_type, severity, status, source_ip, assigned_to, notes, created_at, updated_at, resolved_at) VALUES
(1, 'Brute force a partir de 203.0.113.45', 'brute_force', 'high', 'open', '203.0.113.45', NULL, NULL,
    NOW() - INTERVAL 2940 SECOND, NOW() - INTERVAL 2940 SECOND, NULL),
(2, 'Port scan a partir de 198.51.100.23', 'port_scan', 'medium', 'investigating', '198.51.100.23', 2, 'A analisar os logs da firewall.',
    NOW() - INTERVAL 10750 SECOND, NOW() - INTERVAL 10000 SECOND, NULL),
(3, 'Login suspeito de 203.0.113.77', 'suspicious_login', 'high', 'resolved', '203.0.113.77', 2, 'Utilizador contactado e password reposta.',
    NOW() - INTERVAL 17800 SECOND, NOW() - INTERVAL 15000 SECOND, NOW() - INTERVAL 15000 SECOND),
(4, 'Brute force a partir de 203.0.113.99', 'brute_force', 'critical', 'open', '203.0.113.99', NULL, NULL,
    NOW() - INTERVAL 1170 SECOND, NOW() - INTERVAL 1170 SECOND, NULL);

-- 5) Ligação entre incidentes e eventos
INSERT INTO incident_events (incident_id, event_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
(2, 7), (2, 8), (2, 9), (2, 10), (2, 11), (2, 12), (2, 13), (2, 14), (2, 15), (2, 16),
(3, 17), (3, 18), (3, 19),
(4, 22), (4, 23), (4, 24), (4, 25), (4, 26), (4, 27);