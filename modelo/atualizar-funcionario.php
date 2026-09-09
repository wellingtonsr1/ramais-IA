<?php
/**
 * Updates an employee by id.
 */

require_once "conecta-banco.php";

function atualizarFuncionario($idFunc, $nome, $telefone, $idSetor): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'UPDATE funcionarios SET nome = :nome, telefone = :telefone, fk_idSetor = :idSetor WHERE idFunc = :idFunc'
        );
        $stmt->bindValue(':idFunc', (int)$idFunc, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':telefone', ($telefone === '' ? null : $telefone));
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao atualizar funcionario: ' . $e->getMessage());
        return false;
    }
}
