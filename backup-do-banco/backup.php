<?php
/**
 * Database backup (mysqldump-php).
 * SECURITY (P-16): previously executable by anyone via URL. Now it only runs
 * on the CLI or for an authenticated admin session. P-01: credentials come
 * from includes/config.php (never committed).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

$ehCli = (PHP_SAPI === 'cli');
if (!$ehCli) {
    if (($_SESSION['autenticado'] ?? '') !== 'SIM' || ($_SESSION['nivel'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Acesso negado.');
    }
    cabecalhos_seguranca();
}

// Incluindo a classe que criamos e a biblioteca de dump
require_once __DIR__ . '/class/BackupDatabase.php';
require_once __DIR__ . '/mysqldump/Mysqldump.php';

// Credentials from the external config (or environment variables)
$caminhoConfig = __DIR__ . '/../includes/config.php';
if (is_file($caminhoConfig)) {
    $config = require $caminhoConfig;
} else {
    $config = [
        'db' => [
            'host' => getenv('DB_HOST') ?: 'localhost',
            'name' => getenv('DB_NAME') ?: 'listagemDeRamais',
            'user' => getenv('DB_USER') ?: '',
            'pass' => getenv('DB_PASS') ?: '',
        ],
    ];
}
$db = $config['db'];

// Como a geração do backup pode ser demorada, retiramos o limite de execução
set_time_limit(0);

$directory = __DIR__ . '/backups';
if (!is_dir($directory)) {
    mkdir($directory, 0770, true);
}

// Gera um backup na pasta 'backups' e mantém os últimos dez arquivos
$backup = new BackupDatabase($directory, 10);
$backup->setDatabase($db['host'], $db['name'], $db['user'], $db['pass']);

try {
    $backup->generate();
} catch (Exception $e) {
    error_log('[ramais] Erro ao gerar backup: ' . $e->getMessage());
    if (!$ehCli) {
        header('Location: ../visao/mensagem.php?msg=erroBackup');
    }
    exit(1);
}

if (!$ehCli) {
    header('Location: ../visao/mensagem.php?msg=backupRealizado');
}
