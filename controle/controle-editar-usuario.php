<?php
/**
 * Updates a user's level/email (admin only).
 * SECURITY (P-30): the current level is read from the DATABASE by id,
 * not from the form - protects the last admin against parameter manipulation.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/atualizar-usuario.php';
require_once __DIR__ . '/../modelo/buscar-usuario.php';
require_once __DIR__ . '/../modelo/contar-nivel-usuario.php';

if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}
cabecalhos_seguranca();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !eh_post_valido()) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-usuarios.php');
}

$id    = requisicao_id('id');
$nivel = post_str('nivel');

if ($id === null || !nivel($nivel)) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-usuarios.php');
}

$registro = buscarUsuarioPorId($id);

if ($registro === null) {
    $_SESSION['status'] = 'erroEditar';
    redirecionar('../visao/listar-usuarios.php');
}

$email = strtolower(post_str('email'));
$email = ($email === '') ? 'não informado' : $email;

$levelAtualDoAlvo = $registro['nivel'];
$totalAdmins      = contarNivel();

// last admin cannot be demoted (P-10, now based on database data)
if ($levelAtualDoAlvo === 'admin' && $totalAdmins <= 1 && $nivel !== 'admin') {
    $_SESSION['status'] = ($totalAdmins === 1) ? 'erroEditarAdmin' : 'erroEditar';
} else {
    $_SESSION['status'] = atualizarUsuario($id, $nivel, $email) ? 'sucessoEditar' : 'erroEditar';
}
redirecionar('../visao/listar-usuarios.php');
