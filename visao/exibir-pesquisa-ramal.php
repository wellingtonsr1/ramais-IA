<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/controle-buscar-ramal.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('../visao/form-alterar-senha.php');
}

$exibirBotoes = in_array($_SESSION['nivel'] ?? '', ['admin', 'atendente'], true);
$ehAdmin      = ($_SESSION['nivel'] ?? '') === 'admin';

// P-19: guarded POST access (this page can be opened directly by URL)
$encoding  = mb_internal_encoding();
$setor     = mb_strtoupper(post_str('setor'), $encoding);
$registros = pegarSetoresPorPrefixo($setor);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Pesquisar ramal</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="../index.php">Home</a>
                    <a href="listar-ramais.php">Exibir lista</a>
                </div>
            </div>

            <div id="area-tabela">
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Setor</th>
                            <th>Ramal</th>
                            <th class="email">Responsável</th> <!-- P-21: removed the 's' typo -->
                            <?php if ($exibirBotoes): ?>
                                <th>Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $dados): ?>
                            <?php $ramalExibido = ($dados['ramal'] == 0) ? '' : $dados['ramal']; ?>
                            <tr>
                                <td><?= e((string)$dados['setor']) ?></td>
                                <td class="center"><?= e((string)$ramalExibido) ?></td>
                                <td class="email"><?= e((string)($dados['responsavel'] ?? '')) ?></td>

                                <?php if ($exibirBotoes): ?>
                                    <td class="alinhamento-btn">
                                        <a class="btn-funcionarios" title="Exibir Funcionários" href="listar-funcionarios-com-setor.php?idSetor=<?= (int)$dados['idSetor'] ?>&setor=<?= urlencode((string)$dados['setor']) ?>"></a>
                                        <a class="btn-editar" title="Alterar ramal" href="form-editar-ramal.php?idSetor=<?= (int)$dados['idSetor'] ?>&setor=<?= urlencode((string)$dados['setor']) ?>&ramal=<?= urlencode((string)$ramalExibido) ?>&responsavel=<?= urlencode((string)($dados['responsavel'] ?? '')) ?>"></a>

                                        <?php if ($ehAdmin): ?>
                                            <form action="../controle/controle-deletar-ramal.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dados['setor']) ?> ?');">
                                                <?php echo campo_csrf(); ?>
                                                <input type="hidden" name="idSetor" value="<?= (int)$dados['idSetor'] ?>">
                                                <button type="submit" class="btn-excluir" title="Excluir ramal"></button>
                                            </form>
                                        <?php endif; ?>
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
</html>
