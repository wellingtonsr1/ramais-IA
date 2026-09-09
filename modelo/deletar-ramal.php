<?php
/**
 * Deletes a sector/ramal by id. The controller must ensure the sector has no employees.
 */

require_once "conecta-banco.php";

function deletarRamal($idSetor): bool
{
    try {
        $stmt = obter_conexao()->prepare('DELETE FROM setores WHERE idSetor = :idSetor');
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao deletar ramal: ' . $e->getMessage());
        return false;
    }
}
