<?php
/**
 * Provides pegarListaFuncionarios($setor): employees filtered by sector or name.
 */

require_once __DIR__ . '/../modelo/buscar-lista-funcionarios-por-setor.php';

function pegarListaFuncionarios($setor)
{
    return buscarSetorFuncionarios($setor);
}
