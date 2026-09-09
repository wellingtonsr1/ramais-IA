<?php
/**
 * Provides pegarListaFuncionarios(): all employees (public listing).
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../modelo/buscar-lista-funcionarios.php';

function pegarListaFuncionarios()
{
    return buscarFuncionarios();
}
