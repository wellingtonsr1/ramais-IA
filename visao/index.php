<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== 'SIM') {
    redirecionar('visao/login.php');
}

cabecalhos_seguranca();

$nivel = $_SESSION['nivel'] ?? '';
switch ($nivel) {
    case 'admin':
        redirecionar('visao/admin.php');
    case 'atendente':
        redirecionar('visao/atendente.php');
    default:
        redirecionar('visao/listar-ramais.php');
}
