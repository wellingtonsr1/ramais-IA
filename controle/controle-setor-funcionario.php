<?php
/**
 * Provides pegarSetorFuncionario($setor): sectors + responsible filtered for the public filter.
 */

require_once __DIR__ . '/../modelo/buscar-lista-funcionarios-por-setor.php';

function pegarSetorFuncionario($setor)
{
    return buscarSetorFuncionario($setor);
}
