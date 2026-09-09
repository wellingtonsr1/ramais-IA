<?php
/**
 * Deletes an employee (admin only).
 * SECURITY (P-08): was a GET link - now POST with CSRF.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/deletar-funcionario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

$idFunc = requisicao_id('idFunc');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido() || $idFunc === null) {
    $_SESSION['status'] = 'erroDel';
    redirecionar('../visao/listar-funcionarios.php');
}

$_SESSION['status'] = deletarFuncionario($idFunc) ? 'sucessoDel' : 'erroDel';
redirecionar('../visao/listar-funcionarios.php');
