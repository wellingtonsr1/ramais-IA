<?php
/**
 * Username uniqueness check (exact match) used by controle/controle-adicionar-usuario.php.
 * Returns the number of matching users, or -1 on database failure (fail safe:
 * the controller treats anything different from 0 as 'user already exists').
 */

require_once "conecta-banco.php";

function existeUsuario($usuario): int
{
    try {
        $stmt = obter_conexao()->prepare('SELECT COUNT(*) AS total FROM usuarios WHERE usuario = :usuario');
        $stmt->bindValue(':usuario', $usuario);
        $stmt->execute();
        $linha = $stmt->fetch();
        return (int)($linha['total'] ?? 0);
    } catch (Exception $e) {
        error_log('[ramais] Erro ao verificar existencia de usuario: ' . $e->getMessage());
        return -1;
    }
}
