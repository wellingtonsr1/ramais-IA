<?php
/**
 * Inserts a new system user.
 */

require_once "conecta-banco.php";

function adicionarUsuario($usuario, $hashSenha, $nivel, $email, $primeiroacesso): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'INSERT INTO usuarios (usuario, hashSenha, nivel, email, primeiroacesso) VALUES (:usuario, :hashSenha, :nivel, :email, :primeiroacesso)'
        );
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':hashSenha', $hashSenha);
        $stmt->bindValue(':nivel', $nivel);
        $stmt->bindValue(':email', ($email === '' ? null : $email));
        $stmt->bindValue(':primeiroacesso', $primeiroacesso);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao inserir usuario: ' . $e->getMessage());
        return false;
    }
}
