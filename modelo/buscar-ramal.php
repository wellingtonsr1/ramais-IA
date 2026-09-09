<?php
/**
 * Public sector search by name prefix - visao/exibir-pesquisa-ramal.php.
 */

require_once "conecta-banco.php";

function buscarSetor($setor)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT DISTINCT s.setor, s.idSetor, s.ramal, s.responsavel
               FROM funcionarios f
               RIGHT JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE s.setor LIKE :setor
              ORDER BY s.setor'
        );
        $stmt->bindValue(':setor', $setor . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar setor: ' . $e->getMessage());
        return [];
    }
}
