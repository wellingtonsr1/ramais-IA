<?php
/**
 * Provides pegarListaSetores($setor): public sector search by prefix.
 */

require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../controle/funcoes-de-controle.php';
require_once __DIR__ . '/../modelo/buscar-ramal.php';

function pegarSetoresPorPrefixo($setor)
{
    if (setor($setor)) {
        return buscarSetor($setor);
    }
    return [];
}
