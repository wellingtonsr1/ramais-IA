<?php
/**
 * Deletes a user by id. The controller must protect the last admin.
 */

require_once "conecta-banco.php";

function deletarUsuario($id): bool
{
    try {
        $stmt = obter_conexao()->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao deletar usuario: ' . $e->getMessage());
        return false;
    }
}
