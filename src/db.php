<?php
/**
 * src/db.php — ligação à base de dados com PDO
 * Responsável: Samuel
 */

function get_db(): PDO
{
    // "static" = a variável guarda o valor entre chamadas: a ligação só se faz uma vez
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $config = require __DIR__ . '/../config/config.php';
    date_default_timezone_set($config['app']['timezone']);

    $db  = $config['db'];
    $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // erros viram exceções
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // resultados como arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                    // prepared statements a sério
    ];

    try {
        $pdo = new PDO($dsn, $db['user'], $db['password'], $options);
    } catch (PDOException $e) {
        // O detalhe vai só para o log; o utilizador nunca vê credenciais nem erros do MySQL
        $linha = '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL;
        file_put_contents($config['log_path'] . 'app.log', $linha, FILE_APPEND);
        throw new RuntimeException('Erro ao ligar à base de dados.');
    }

    return $pdo;
}