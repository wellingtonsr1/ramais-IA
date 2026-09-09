<?php
/**
 * Database connection factory.
 *
 * SECURITY: credentials come from the includes/config.php file (never committed;
 * use config.exemplo.php as the template) or environment variables.
 */

function obter_conexao(): PDO
{
    static $conexao = null;
    if ($conexao instanceof PDO) {
        return $conexao;
    }

    // Config lives in includes/config.php (project root / includes), NOT in modelo/.
    $caminhoConfig = dirname(__DIR__) . '/includes/config.php';
    if (is_file($caminhoConfig)) {
        $config = require $caminhoConfig;
    } else {
        $config = [
            'db' => [
                'host' => '',
                'name' => '',
                'user' => '',
                'pass' => '',
            ],
        ];
    }

    $db = $config['db'];
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db['host'], $db['name']);

    try {
        $conexao = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        // Never expose connection details to the end user (P-24).
        error_log('[ramais] Erro de conexao com o banco: ' . $e->getMessage());
        die('Erro interno ao conectar ao banco de dados. Tente novamente mais tarde.');
    }

    return $conexao;
}
