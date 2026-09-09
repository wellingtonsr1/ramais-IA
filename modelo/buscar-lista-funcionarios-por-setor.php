<?php
/**
 * Sector searches used by the listing, public filter and deletion validation.
 */

require_once "conecta-banco.php";

/** All sectors ordered by name (public listing and PDF). */
function buscarSetores()
{
    try {
        $stmt = obter_conexao()->prepare('SELECT idSetor, setor, ramal, responsavel FROM setores ORDER BY setor');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao listar setores: ' . $e->getMessage());
        return [];
    }
}

/** Sector + responsible search (prefix by sector or employee name) - visao/filtrar-ramal.php. */
function buscarSetorFuncionario($setor)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT DISTINCT s.setor, s.idSetor, s.ramal, s.responsavel
               FROM funcionarios f
               RIGHT JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE s.setor LIKE :setor OR f.nome LIKE :nome
              ORDER BY s.setor'
        );
        $stmt->bindValue(':setor', $setor . '%');
        $stmt->bindValue(':nome', $setor . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao filtrar setores: ' . $e->getMessage());
        return [];
    }
}

/** Lists employees filtering by sector name or employee name (prefix). */
function buscarSetorFuncionarios($setor)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT f.idFunc, f.nome, f.telefone, s.idSetor, s.setor, s.ramal, s.responsavel
               FROM funcionarios f
              INNER JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE s.setor LIKE :setor OR f.nome LIKE :nome
              ORDER BY f.nome'
        );
        $stmt->bindValue(':setor', $setor . '%');
        $stmt->bindValue(':nome', $setor . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao filtrar funcionarios por setor: ' . $e->getMessage());
        return [];
    }
}

/** Lists employees of a specific sector (exact id) - visao/listar-funcionarios-com-setor.php. */
function buscarFuncionariosPorSetor($idSetor)
{
    try {
        $stmt = obter_conexao()->prepare(
            'SELECT f.idFunc, f.nome, f.telefone, s.idSetor, s.setor, s.ramal, s.responsavel
               FROM funcionarios f
              INNER JOIN setores s ON s.idSetor = f.fk_idSetor
              WHERE s.idSetor = :idSetor
              ORDER BY f.nome'
        );
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('[ramais] Erro ao listar funcionarios do setor: ' . $e->getMessage());
        return [];
    }
}

/**
 * Counts employees of a sector (P-30 basis: replaces the deletion check by sector NAME).
 * Returns -1 on failure so controllers can fail safe (block the deletion).
 */
function contarFuncionariosPorSetor($idSetor): int
{
    try {
        $stmt = obter_conexao()->prepare('SELECT COUNT(*) AS total FROM funcionarios WHERE fk_idSetor = :idSetor');
        $stmt->bindValue(':idSetor', (int)$idSetor, PDO::PARAM_INT);
        $stmt->execute();
        $linha = $stmt->fetch();
        return (int)($linha['total'] ?? 0);
    } catch (Exception $e) {
        error_log('[ramais] Erro ao contar funcionarios do setor: ' . $e->getMessage());
        return -1;
    }
}
