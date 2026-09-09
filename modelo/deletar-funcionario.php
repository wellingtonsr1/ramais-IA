<?php
/**
 * Deletes an employee by id.
 */

require_once "conecta-banco.php";

function deletarFuncionario($idFunc): bool
{
    try {
        $stmt = obter_conexao()->prepare('DELETE FROM funcionarios WHERE idFunc = :idFunc');
        $stmt->bindValue(':idFunc', (int)$idFunc, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao deletar funcionario: ' . $e->getMessage());
        return false;
    }
}
