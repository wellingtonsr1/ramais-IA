<?php
/**
 * Provides pegarListaUsuarios() - admin only.
 */

require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/buscar-lista-usuarios.php';

function pegarListaUsuarios()
{
    return buscarUsuarios();
}
