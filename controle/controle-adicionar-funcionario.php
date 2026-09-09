<?php
/**
 * Creates an employee (admin only).
 * SECURITY: CSRF (P-07) and POST-only (P-08).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/adicionar-funcionario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroAdd';
    redirecionar('../visao/form-adicionar-funcionario.php');
}

$encoding = mb_internal_encoding();
$nome     = mb_strtoupper(post_str('nome'), $encoding);

// removes phone masks before validating
$telefone = str_replace(['(', ')', '-', ' '], '', post_str('telefone'));
$telefone = ($telefone === '') ? '00000000000' : $telefone;

$idSetor = requisicao_id('idSetor');

if ($idSetor === null) {
    $_SESSION['status'] = 'erroAdd';
    redirecionar('../visao/form-adicionar-funcionario.php');
}

if (nome($nome) && telefone($telefone)) {
    $_SESSION['status'] = adicionarFuncionario($nome, $telefone, $idSetor) ? 'sucessoAdd' : 'erroAdd';
} else {
    $_SESSION['status'] = 'erroAdd';
}
redirecionar('../visao/form-adicionar-funcionario.php');
