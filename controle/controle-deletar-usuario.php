<?php
/**
 * Deletes a user (admin only).
 * SECURITY (P-10): operator precedence fixed with parentheses and the current level
 * is read from the DATABASE by id, not from the URL - cannot be manipulated (P-30).
 * SECURITY (P-08): was a GET link - now POST with CSRF.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/deletar-usuario.php';
require_once __DIR__ . '/../modelo/buscar-usuario.php';
require_once __DIR__ . '/../modelo/contar-nivel-usuario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

$id = requisicao_id('id');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido() || $id === null) {
    $_SESSION['status'] = 'erroDel';
    redirecionar('../visao/listar-usuarios.php');
}

$registro = buscarUsuarioPorId($id);

if ($registro === null) {
    $_SESSION['status'] = 'erroDel';
    redirecionar('../visao/listar-usuarios.php');
}

$totalAdmins = contarNivel();
$nivelDoAlvo = $registro['nivel'];

// P-10: parentheses are now explicit - the last admin cannot be deleted
$podeDeletar = ($nivelDoAlvo === 'admin' && $totalAdmins > 1) || $nivelDoAlvo === 'atendente';

if ($podeDeletar) {
    $_SESSION['status'] = deletarUsuario($id) ? 'sucessoDel' : 'erroDel';
} else {
    $_SESSION['status'] = ($totalAdmins === 1) ? 'erroDelAdmin' : 'erroDel';
}
redirecionar('../visao/listar-usuarios.php');
