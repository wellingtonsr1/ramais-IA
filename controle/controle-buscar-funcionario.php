<?php
/**
 * Provides buscarFuncionario($nome) - admin only.
 */

require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/buscar-funcionario.php';

function buscarFuncionario($nome)
{
    return pegarFuncionario($nome);
}
