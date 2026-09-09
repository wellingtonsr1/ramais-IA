-- =============================================================================
-- MELHORIAS OPCIONAIS DE ESTRUTURA - banco 'listagemDeRamais'
--
-- Rode este script UMA VEZ, com backup prévio, apenas após validar os pontos:
--   1) O script FALHARA se existirem setores duplicados (chave UNIQUE).
--      Verifique antes com:  SELECT setor, COUNT(*) c FROM setores GROUP BY setor HAVING c > 1;
--      Corrija/renomeie os duplicados antes de aplicar.
--   2) Nenhum arquivo do sistema executa este script automaticamente.
--   3) Reversão:  ALTER TABLE setores DROP INDEX uk_setores_setor;
--                 ALTER TABLE funcionarios DROP INDEX ix_funcionarios_nome;
-- =============================================================================

-- (a) Alinha o tamanho do campo 'setor' ao que o sistema usa (maxlength=35)
ALTER TABLE `setores` MODIFY `setor` VARCHAR(35) NOT NULL;

-- (b) Impede o cadastro de setores duplicados (P-05 do relatório: sem UNIQUE)
ALTER TABLE `setores` ADD UNIQUE KEY `uk_setores_setor` (`setor`);

-- (c) Acelera as buscas por prefixo em funcionarios (LIKE 'nome%')
ALTER TABLE `funcionarios` ADD KEY `ix_funcionarios_nome` (`nome`);
