<?php
/**
 * Provides pegarListaSetores(): all sectors for listings and forms.
 */

require_once __DIR__ . '/../modelo/buscar-lista-funcionarios-por-setor.php';

function pegarListaSetores()
{
    return buscarSetores();
}
