<?php
/**
 * Inserts a new employee.
 */

require_once "conecta-banco.php";

function adicionarFuncionario($nome, $telefone, $idSetor): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'INSERT INTO funcionarios (nome, telefone, fk_idSetor) VALUES (:nome, :telefone, :idSetor)'
        );
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':telefone', ($telefone === '' ? null : $telefone));
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao inserir funcionario: ' . $e->getMessage());
        return false;
    }
}
