<?php
/**
 * Deletes a sector/ramal (admin only, empty sector only).
 * SECURITY (P-30): the empty-sector check is now by idSetor, not by sector NAME.
 * SECURITY (P-08): was a GET link - now POST with CSRF.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/deletar-ramal.php';
require_once __DIR__ . '/../modelo/buscar-lista-funcionarios-por-setor.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

$idSetor = requisicao_id('idSetor');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido() || $idSetor === null) {
    $_SESSION['status'] = 'erroDel';
    redirecionar('../visao/listar-ramais.php');
}

$total = contarFuncionariosPorSetor($idSetor);

if ($total === 0) {
    $_SESSION['status'] = deletarRamal($idSetor) ? 'sucessoDel' : 'erroDel';
} else {
    // -1 (database failure) or > 0: block the deletion (fail safe)
    $_SESSION['status'] = 'erroDel';
}
redirecionar('../visao/listar-ramais.php');
