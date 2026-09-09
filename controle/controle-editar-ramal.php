<?php
/**
 * Updates a sector/ramal (admin or atendente).
 * SECURITY: CSRF (P-07), POST-only (P-08) and the id must be a positive integer.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/atualizar-ramal.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-ramais.php');
}

$idSetor = requisicao_id('idSetor');

if ($idSetor === null) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-ramais.php');
}

$encoding    = mb_internal_encoding();
$setor       = mb_strtoupper(post_str('setor'), $encoding);
$ramal       = post_str('ramal');
$responsavel = mb_strtoupper(post_str('responsavel'), $encoding); // empty becomes 'NÃO INFORMADO'

if (setor($setor) && ramal($ramal) && responsavel($responsavel)) {
    $_SESSION['status'] = atualizarRamal($idSetor, $setor, $ramal, $responsavel) ? 'sucessoEditar' : 'erroEditar';
} else {
    $_SESSION['status'] = 'erroEditar';
}
redirecionar('../visao/listar-ramais.php');
