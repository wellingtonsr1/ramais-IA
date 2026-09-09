<?php
/**
 * Updates a user's password hash and 'first access' flag.
 */

require_once "conecta-banco.php";

function atualizarSenha($id, $novoHash, $primeiroacesso): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'UPDATE usuarios SET hashSenha = :novoHash, primeiroacesso = :primeiroacesso WHERE id = :id'
        );
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':novoHash', $novoHash);
        $stmt->bindValue(':primeiroacesso', $primeiroacesso);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao atualizar senha: ' . $e->getMessage());
        return false;
    }
}
