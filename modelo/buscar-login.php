<?php
/**
 * Fetches the user record by exact username for login.
 * Returns array when found, or null when it does not exist.
 */

require_once "conecta-banco.php";

function buscarUsuario($usuario)
{
    try {
        $stmt = obter_conexao()->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
        $stmt->bindValue(':usuario', $usuario);
        $stmt->execute();
        $registro = $stmt->fetch();
        return $registro === false ? null : $registro;
    } catch (Exception $e) {
        error_log('[ramais] Erro ao buscar usuario para login: ' . $e->getMessage());
        return null;
    }
}
