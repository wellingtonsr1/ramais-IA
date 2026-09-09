<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/../controle/controle-buscar-funcionario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-13: the filter now runs in the DATABASE (LIKE prefix) instead of a
// preg_match with the user input interpolated into the regex pattern
$encoding = mb_internal_encoding();
$nome = mb_strtoupper(post_str('nome'), $encoding);
$funcionarios = ($nome !== '') ? buscarFuncionario($nome) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar Funcionário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="listar-funcionarios.php">Voltar</a>
                    <a href="../index.php">Home</a>
                    <a href="../controle/logoff.php">Sair</a>
                </div>
            </div>

            <div id="area-tabela">
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Setor</th>
                            <th>Telefone</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funcionarios as $dadosFuncionario): ?>
                            <tr>
                                <td><?= e((string)$dadosFuncionario['nome']) ?></td>
                                <td class="center"><?= e((string)$dadosFuncionario['setor']) ?></td>
                                <td class="center"><?= e(formatarTelefone((string)($dadosFuncionario['telefone'] ?? ''))) ?></td>

                                <td class="alinhamento-btn">
                                    <a class="btn-editar" title="Editar funcionário" href="form-editar-funcionario.php?idFunc=<?= (int)$dadosFuncionario['idFunc'] ?>"></a>
                                    <form action="../controle/controle-deletar-funcionario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dadosFuncionario['nome']) ?> ?');">
                                        <?php echo campo_csrf(); ?>
                                        <input type="hidden" name="idFunc" value="<?= (int)$dadosFuncionario['idFunc'] ?>">
                                        <button type="submit" class="btn-excluir" title="Excluir funcionário"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
    <?php include "../includes/cdns.php"; // Swal for the delete confirmation ?>
</html>
