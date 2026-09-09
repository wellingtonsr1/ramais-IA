<?php
/**
 * Login processing.
 * SECURITY (P-06): the old comparison (isset(...) == $_POST['usuario']) compared
 * boolean to string and broke on PHP 8. Existence is now checked explicitly.
 * SECURITY (P-15): session_regenerate_id(true) on login prevents session fixation.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

require_once __DIR__ . '/../modelo/buscar-login.php';

$usuario = post_str('usuario');
$senha   = (string)($_POST['senha'] ?? ''); // the password is not trimmed

// P-07: the login form also carries a CSRF token - validate it before anything else.
if (!eh_post_valido()) {
    $_SESSION['autenticado'] = 'NAO';
    redirecionar('../visao/login.php?login=erro');
}

if ($usuario === '' || $senha === '') {
    $_SESSION['autenticado'] = 'NAO';
    redirecionar('../visao/login.php?login=erro');
}

$dadosUsuario = buscarUsuario($usuario);

// P-06: the record must exist AND the username must match exactly.
$hash = is_array($dadosUsuario) ? (string)($dadosUsuario['hashSenha'] ?? '') : '';
$senhaVerificada = ($hash !== '') && password_verify($senha, $hash);
$usuarioConfere  = is_array($dadosUsuario) && (($dadosUsuario['usuario'] ?? null) === $usuario);

if ($usuarioConfere && $senhaVerificada) {
    session_regenerate_id(true); // prevents session fixation

    $_SESSION['autenticado']    = 'SIM';
    $_SESSION['id']             = (int)$dadosUsuario['id'];
    $_SESSION['usuario']        = $dadosUsuario['usuario'];
    $_SESSION['nivel']          = $dadosUsuario['nivel'];
    $_SESSION['primeiroacesso'] = $dadosUsuario['primeiroacesso'];
    $_SESSION['ultimo_acesso']  = time();

    if ($dadosUsuario['primeiroacesso'] === 'sim') {
        redirecionar('../visao/form-alterar-senha.php');
    }
    redirecionar(($_SESSION['nivel'] === 'admin') ? '../visao/admin.php' : '../visao/atendente.php');
}

$_SESSION['autenticado'] = 'NAO';
redirecionar('../visao/login.php?login=erro');
