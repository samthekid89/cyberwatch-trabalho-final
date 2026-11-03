<?php
/**
 * config/config.example.php — configuração da aplicação CyberWatch
 *
 * MODELO (vai para o Git): sem credenciais reais. Copiar para config.php.
 * Uso: $config = require __DIR__ . '/../config/config.php';
 */
return [
    "db" => [
        "host"     => "localhost",
        "name"     => "cyberwatch",
        "user"     => "root",
        "password" => "",            // XAMPP: vazia por defeito
        "charset"  => "utf8mb4",
    ],
    "app" => [
        "env"          => "dev",     // 'dev' | 'prod'
        "timezone"     => "Europe/Lisbon",
        "session_name" => "cyberwatch_sid",
    ],
    "session" => [
        "lifetime" => 3600,          // 1 hora
        "httponly" => true,
        "samesite" => "Lax",
        "secure"   => false,         // true apenas se houver HTTPS
    ],
    "detection" => [                 // valores por defeito (opcional)
        "brute_force"      => ["threshold" => 5,  "window" => 60],
        "port_scan"        => ["threshold" => 10, "window" => 30],
        "suspicious_login" => ["threshold" => 3,  "window" => 300],
    ],
    "log_path" => __DIR__ . "/../logs/",
];
