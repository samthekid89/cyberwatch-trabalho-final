-- database/schema.sql — estrutura da base de dados `cyberwatch`
-- Motor: InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
--
-- Como usar: phpMyAdmin -> Importar -> escolher este ficheiro -> Executar.
-- Pode ser importado várias vezes: apaga as tabelas antigas e cria tudo de novo.
-- Depois importar o seed.sql (dados de teste).

CREATE DATABASE IF NOT EXISTS cyberwatch
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cyberwatch;

-- Apagar primeiro as tabelas que dependem de outras

DROP TABLE IF EXISTS incident_events;
DROP TABLE IF EXISTS incidents;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS detection_rules;
DROP TABLE IF EXISTS users;

-- (1) users: quem pode entrar na aplicação
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('admin','analista') NOT NULL DEFAULT 'analista',
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- (2) detection_rules: regras que decidem quando há um incidente
CREATE TABLE detection_rules (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(100) NOT NULL,
    attack_type         ENUM('brute_force','port_scan','suspicious_login') NOT NULL UNIQUE,
    threshold           INT NOT NULL,
    time_window_seconds INT NOT NULL,
    enabled             TINYINT(1) NOT NULL DEFAULT 1,
    updated_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- (3) events: o diário de tudo o que aconteceu (logs)
CREATE TABLE events (
    id          BIGINT AUTO_INCREMENT PRIMARY KEY,
    `timestamp` DATETIME NOT NULL,
    source_ip   VARCHAR(45) NOT NULL,
    event_type  ENUM('login_failed','port_scan_probe','suspicious_login') NOT NULL,
    severity    ENUM('low','medium','high','critical') NOT NULL,
    description VARCHAR(255) NOT NULL,
    INDEX idx_events_timestamp (`timestamp`),
    INDEX idx_events_detection (source_ip, event_type, `timestamp`)
) ENGINE=InnoDB;

-- (4) incidents: problemas de segurança que alguém tem de investigar
CREATE TABLE incidents (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    attack_type ENUM('brute_force','port_scan','suspicious_login') NOT NULL,
    severity    ENUM('low','medium','high','critical') NOT NULL,
    status      ENUM('open','investigating','resolved') NOT NULL DEFAULT 'open',
    source_ip   VARCHAR(45) NOT NULL,
    assigned_to INT NULL,
    notes       TEXT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,
    resolved_at DATETIME NULL,
    INDEX idx_incidents_status (status),
    INDEX idx_incidents_severity (severity),
    INDEX idx_incidents_lookup (source_ip, attack_type, status),
    CONSTRAINT fk_incidents_user
        FOREIGN KEY (assigned_to) REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- (5) incident_events: liga cada incidente aos eventos que o provocaram
CREATE TABLE incident_events (
    incident_id INT    NOT NULL,
    event_id    BIGINT NOT NULL,
    PRIMARY KEY (incident_id, event_id),
    CONSTRAINT fk_ie_incident
        FOREIGN KEY (incident_id) REFERENCES incidents(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_ie_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;