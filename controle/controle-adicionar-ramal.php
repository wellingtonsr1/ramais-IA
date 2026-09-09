<?php
/**
 * Creates a sector/ramal (admin or atendente).
 * SECURITY: CSRF (P-07) and POST-only (P-08).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/inserir-ramal.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroAdd';
    redirecionar('../visao/form-adicionar-ramal.php');
}

$encoding    = mb_internal_encoding();
$setor       = mb_strtoupper(post_str('setor'), $encoding);
$ramal       = post_str('ramal');
$responsavel = mb_strtoupper(post_str('responsavel'), $encoding);

if (setor($setor) && ramal($ramal) && responsavel($responsavel)) {
    $_SESSION['status'] = adicionarRamal($setor, $ramal, $responsavel) ? 'sucessoAdd' : 'erroAdd';
} else {
    $_SESSION['status'] = 'erroAdd';
}
redirecionar('../visao/form-adicionar-ramal.php');
