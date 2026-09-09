<?php
/**
 * Lists all system users (admin screens).
 * Note: SELECT of specific columns so the password hash never travels to views.
 */

require_once "conecta-banco.php";

function buscarUsuarios()
{
    try {
        $stmt = obter_conexao()->prepare('SELECT id, usuario, nivel, email, primeiroacesso FROM usuarios ORDER BY usuario');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao listar usuarios: ' . $e->getMessage());
        return [];
    }
}
