<?php
/**
 * Inserts a new sector/ramal.
 */

require_once "conecta-banco.php";

function adicionarRamal($setor, $ramal, $responsavel): bool
{
    try {
        $stmt = obter_conexao()->prepare(
            'INSERT INTO setores (setor, ramal, responsavel) VALUES (:setor, :ramal, :responsavel)'
        );
        $stmt->bindValue(':setor', $setor);
        $stmt->bindValue(':ramal', $ramal);
        $stmt->bindValue(':responsavel', ($responsavel === '' ? null : $responsavel));
        return $stmt->execute();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao inserir ramal: ' . $e->getMessage());
        return false;
    }
}
