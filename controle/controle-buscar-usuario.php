<?php
/**
 * Provides verificarUsuario($usuario) - admin only.
 */

require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../controle/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/buscar-usuario.php';

function verificarUsuario($usuario)
{
    if (usuario($usuario)) {
        return buscarUsuarioPorPrefixo($usuario);
    }
    return [];
}
