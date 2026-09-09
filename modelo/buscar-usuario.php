<?php
/**
 * Searches users by username prefix (admin) - visao/exibir-pesquisa-usuario.php.
 * Returns an empty array when the record does not exist (callers iterate safely).
 */

require_once "conecta-banco.php";

function buscarUsuarioPorPrefixo($usuario)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT id, usuario, nivel, email, primeiroacesso FROM usuarios WHERE usuario LIKE :usuario ORDER BY usuario'
        );
        $stmt->bindValue(':usuario', $usuario . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar usuario: ' . $e->getMessage());
        return [];
    }
}

/** Fetches one user by exact id - P-30: controllers validate level from the database. */
function buscarUsuarioPorId($id)
{
    try {
        $stmt = obter_conexao()->prepare('SELECT id, usuario, nivel, email, primeiroacesso FROM usuarios WHERE id = :id');
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch();
        return $registro === false ? null : $registro;
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar usuario por id: ' . $e->getMessage());
        return null;
    }
}
