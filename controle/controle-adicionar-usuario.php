<?php
/**
 * Creates a system user (admin only).
 * SECURITY: CSRF (P-07) and POST-only (P-08).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/inserir-usuario.php';
require_once __DIR__ . '/../modelo/existe-usuario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroAdd';
    redirecionar('../visao/form-adicionar-usuario.php');
}

$usuario = post_str('usuario'); // lowercase enforced by the validator regex
$senha   = (string)($_POST['senha'] ?? ''); // passwords are not trimmed
$nivel   = strtolower(post_str('nivel'));

// P-14: the checkbox only arrives when checked; absence means 'nao'
$primeiroacesso = isset($_POST['primeiroacesso']) ? 'sim' : 'nao';

$email = strtolower(post_str('email'));
$email = ($email === '') ? 'não informado' : $email;

if (usuario($usuario) && senha($senha) && nivel($nivel) && email($email) && primeiroacesso($primeiroacesso)) {
    $hashSenha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);

    if (existeUsuario($usuario) === 0) {
        $_SESSION['status'] = adicionarUsuario($usuario, $hashSenha, $nivel, $email, $primeiroacesso) ? 'sucessoAdd' : 'erroAdd';
    } else {
        $_SESSION['status'] = 'erroAddExiste';
    }
} else {
    $_SESSION['status'] = 'erroAdd';
}
redirecionar('../visao/form-adicionar-usuario.php');
