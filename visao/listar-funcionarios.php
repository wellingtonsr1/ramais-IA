<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/controle-listar-funcionarios.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-36: single source of truth for the button area
$ehAdmin = ($_SESSION['nivel'] ?? '') === 'admin';
$exibirBotoes = $ehAdmin;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar Funcionários</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar">
                    <?php if ($ehAdmin): // the filter result page is admin-only ?>
                    <form action="filtrar-funcionario.php" method="post">
                        <?php echo campo_csrf(); ?>
                        <input class="campo-filtrar" type="text" name="nome" id="nome" placeholder="Informe o nome" autocomplete="off" autocorrect="off" autofocus required>
                        <button class="btn-filtrar" id="btnBusca">Filtrar</button>
                    </form>
                    <?php endif; ?>
                </div>

                <div class="lado-direito-filtrar">
                    <?php if ($ehAdmin): ?>
                        <a href="form-adicionar-funcionario.php">Adicionar</a>
                    <?php endif; ?>
                    <a href="../index.php">Home</a>
                    <?php if ($ehAdmin): ?>
                        <a href="../controle/logoff.php">Sair</a>
                    <?php endif; ?>
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
                                <th>Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listaDeRegistros = pegarListaFuncionarios(); ?>
                        <?php foreach ($listaDeRegistros as $dadosFuncionario): ?>
                            <tr>
                                <td><?= e((string)$dadosFuncionario['nome']) ?></td>
                                <td class="center"><?= e((string)$dadosFuncionario['setor']) ?></td>
                                <td class="center"><?= e(formatarTelefone((string)($dadosFuncionario['telefone'] ?? ''))) ?></td>

                                <?php if ($exibirBotoes): ?>
                                    <td class="alinhamento-btn">
                                        <a class="btn-editar" title="Editar funcionário" aria-label="Editar funcionário <?= e((string)$dadosFuncionario['nome']) ?>" href="form-editar-funcionario.php?idFunc=<?= (int)$dadosFuncionario['idFunc'] ?>"></a>
                                        <!-- P-08: deletion is now a POST form with CSRF -->
                                        <form action="../controle/controle-deletar-funcionario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dadosFuncionario['nome']) ?> ?');">
                                            <?php echo campo_csrf(); ?>
                                            <input type="hidden" name="idFunc" value="<?= (int)$dadosFuncionario['idFunc'] ?>">
                                            <button type="submit" class="btn-excluir" title="Excluir funcionário" aria-label="Excluir funcionário <?= e((string)$dadosFuncionario['nome']) ?>"></button>
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
    <?php
    if (!empty($_SESSION['status'])) {
        switch ($_SESSION['status']) {
            case 'sucessoDel': ?>
                <script> sucessoDel('listar-funcionarios.php') </script>
                <?php break;
            case 'erroDel': ?>
                <script> erroDel('listar-funcionarios.php', 'Erro ao excluir o registro!') </script>
                <?php break;
            case 'sucessoEditar': ?>
                <script> sucessoEditar('listar-funcionarios.php') </script>
                <?php break;
            case 'erroEditar': ?>
                <script> erroEditar('listar-funcionarios.php', 'Não foi possível alterar os dados!') </script>
                <?php break;
        }
        unset($_SESSION['status']);
    }
    ?>
</html>
