<?php
/**
 * Updates a user's own password (option 'alt') or resets another user's password (option 'reset').
 * SECURITY (P-12): $opcao always has a defined value; missing session -> treated as 'alt'.
 * SECURITY (P-07): CSRF enforced. PHP 8: every index access is guarded.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/atualizar-senha.php';

cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroSenha';
    redirecionar('../visao/form-alterar-senha.php');
}

$id = requisicao_id('id');
if ($id === null) {
    $_SESSION['status'] = 'erroSenha';
    redirecionar('../visao/form-alterar-senha.php');
}

// P-12: a reset request without the admin flag in session is NOT accepted
$opcao = 'alt';
if (($_SESSION['nivel'] ?? '') === 'admin' && ($_SESSION['opcao'] ?? '') === 'reset') {
    $opcao = 'reset';
}

$novaSenha       = (string)($_POST['novaSenha'] ?? '');
$senhaConfirmada = (string)($_POST['senhaConfirmada'] ?? '');

if (!verificarSenhas($novaSenha, $senhaConfirmada)) {
    $_SESSION['status'] = 'erroSenha';
    redirecionar(($opcao === 'reset') ? '../visao/form-redefinir-senha.php?id=' . $id : '../visao/form-alterar-senha.php');
}

if ($novaSenha !== $senhaConfirmada) {
    $_SESSION['status'] = 'senhasDiferentes';
    redirecionar(($opcao === 'reset') ? '../visao/form-redefinir-senha.php?id=' . $id : '../visao/form-alterar-senha.php');
}

$primeiroacesso = isset($_POST['primeiroacesso']) ? 'sim' : 'nao';

// safety net: 'alt' must always target the session user, never a foreign id
if ($opcao === 'alt' && (int)$id !== (int)($_SESSION['id'] ?? 0)) {
    $_SESSION['status'] = 'erroSenha';
    redirecionar('../visao/form-alterar-senha.php');
}

$novoHashSenha = password_hash($novaSenha, PASSWORD_BCRYPT, ['cost' => 10]);

if (!atualizarSenha($id, $novoHashSenha, $primeiroacesso)) {
    $_SESSION['status'] = 'erroSenha';
    redirecionar(($opcao === 'reset') ? '../visao/form-redefinir-senha.php?id=' . $id : '../visao/form-alterar-senha.php');
}

if ($opcao === 'reset') {
    $_SESSION['status'] = 'sucessoRedfSenha';
    redirecionar('../visao/listar-usuarios.php');
}

// own password change: end the session and ask for a new login
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();

// P-11: no more session_destroy + silent SweetAlert queue - plain redirect with a readable flag
redirecionar('../visao/login.php?senha=alterada');
