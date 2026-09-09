<?php
/**
 * Employee search by name prefix - visao/exibir-pesquisa-funcionario.php (admin).
 */

require_once "conecta-banco.php";

function pegarFuncionario($nome)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT f.idFunc, f.nome, f.telefone, s.idSetor, s.setor
               FROM funcionarios f
              INNER JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE f.nome LIKE :nome
              ORDER BY f.nome'
        );
        $stmt->bindValue(':nome', $nome . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar funcionario: ' . $e->getMessage());
        return [];
    }
}

/** Fetches one employee by exact id - used by visao/form-editar-funcionario.php (P-04). */
function buscarFuncionarioPorId($idFunc)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT f.idFunc, f.nome, f.telefone, s.idSetor, s.setor
               FROM funcionarios f
              INNER JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE f.idFunc = :idFunc'
        );
        $stmt->bindValue(':idFunc', (int)$idFunc, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch();
        return $registro === false ? null : $registro;
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar funcionario por id: ' . $e->getMessage());
        return null;
    }
}
