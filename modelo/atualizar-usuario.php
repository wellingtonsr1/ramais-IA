<?php
/**
 * Updates user level and email by id.
 */

require_once "conecta-banco.php";

function atualizarUsuario($id, $nivel, $email): bool
{
    try {
        $stmt = obter_conexao()->prepare('UPDATE usuarios SET nivel = :nivel, email = :email WHERE id = :id');
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':nivel', $nivel);
        $stmt->bindValue(':email', ($email === '' ? null : $email));
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao atualizar usuario: ' . $e->getMessage());
        return false;
    }
}
