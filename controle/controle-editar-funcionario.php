<?php
/**
 * Updates an employee (admin only).
 * SECURITY: CSRF (P-07), POST-only (P-08) and integer ids.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/atualizar-funcionario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-funcionarios.php');
}

$idFunc  = requisicao_id('idFunc');
$idSetor = requisicao_id('idSetor');

if ($idFunc === null || $idSetor === null) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-funcionarios.php');
}

$encoding = mb_internal_encoding();
$nome     = mb_strtoupper(post_str('nome'), $encoding);

$telefone = str_replace(['(', ')', '-', ' '], '', post_str('telefone'));
$telefone = ($telefone === '') ? '00000000000' : $telefone;

if (nome($nome) && telefone($telefone)) {
    $_SESSION['status'] = atualizarFuncionario($idFunc, $nome, $telefone, $idSetor) ? 'sucessoEditar' : 'erroEditar';
} else {
    $_SESSION['status'] = 'erroEditar';
}
redirecionar('../visao/listar-funcionarios.php');
