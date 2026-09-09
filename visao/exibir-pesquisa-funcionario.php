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

$ehAdmin = ($_SESSION['nivel'] ?? '') === 'admin';
$exibirBotoes = $ehAdmin;

$encoding = mb_internal_encoding();
$nome = mb_strtoupper(post_str('nome'), $encoding);
$listaDeRegistros = ($nome !== '') ? buscarFuncionario($nome) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar Funcionários</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
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
                            <?php if ($exibirBotoes): ?>
                                <th class="acao">Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaDeRegistros as $dadosFuncionario): ?>
                            <tr>
                                <td><?= e((string)$dadosFuncionario['nome']) ?></td>
                                <td class="center"><?= e((string)$dadosFuncionario['setor']) ?></td>
                                <td class="center"><?= e(formatarTelefone((string)($dadosFuncionario['telefone'] ?? ''))) ?></td>

                                <?php if ($exibirBotoes): ?>
                                    <td class="alinhamento-btn">
                                        <a class="btn-editar" title="Editar funcionário" href="form-editar-funcionario.php?idFunc=<?= (int)$dadosFuncionario['idFunc'] ?>"></a>
                                        <form action="../controle/controle-deletar-funcionario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dadosFuncionario['nome']) ?> ?');">
                                            <?php echo campo_csrf(); ?>
                                            <input type="hidden" name="idFunc" value="<?= (int)$dadosFuncionario['idFunc'] ?>">
                                            <button type="submit" class="btn-excluir" title="Excluir funcionário"></button>
                                        </form>
                                    </td>
                                <?php endif; ?>
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
