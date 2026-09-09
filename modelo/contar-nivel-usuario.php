<?php
/**
 * Counts how many 'admin' level users exist (last-admin protection).
 */

require_once "conecta-banco.php";

function contarNivel(): int
{
    try {
        $stmt = obter_conexao()->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE nivel = 'admin'");
        $stmt->execute();
        $linha = $stmt->fetch();
        return (int)($linha['total'] ?? 0);
    } catch (Exception $e) {
        error_log('[ramais] Erro ao contar administradores: ' . $e->getMessage());
        return -1;
    }
}
