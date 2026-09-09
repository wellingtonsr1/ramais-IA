<?php
/**
 * Access guard: requires authenticated session with 'atendente' level.
 * SECURITY (P-05): redirects AND terminates execution (redirecionar() calls exit).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== 'SIM' || ($_SESSION['nivel'] ?? '') !== 'atendente') {
    redirecionar('../visao/login.php?login=erro2');
}
