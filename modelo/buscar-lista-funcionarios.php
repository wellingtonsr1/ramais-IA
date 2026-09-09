<?php
/**
 * Lists all employees (public screen visao/listar-funcionarios.php).
 */

require_once "conecta-banco.php";

function buscarFuncionarios()
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT f.idFunc, f.nome, f.telefone, s.setor
               FROM funcionarios f
              INNER JOIN setores s ON s.idSetor = f.fk_idSetor
              ORDER BY f.nome'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao listar funcionarios: ' . $e->getMessage());
        return [];
    }
}
