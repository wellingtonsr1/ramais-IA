<?php
/**
 * Updates a sector/ramal by its id.
 */

require_once "conecta-banco.php";

function atualizarRamal($idSetor, $setor, $ramal, $responsavel): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'UPDATE setores SET setor = :setor, ramal = :ramal, responsavel = :responsavel WHERE idSetor = :idSetor'
        );
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        $stmt->bindValue(':setor', $setor);
        $stmt->bindValue(':ramal', $ramal);
        $stmt->bindValue(':responsavel', ($responsavel === '' ? null : $responsavel));
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao atualizar ramal: ' . $e->getMessage());
        return false;
    }
}
