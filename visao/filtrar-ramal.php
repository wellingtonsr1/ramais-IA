<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/controle-setor-funcionario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

$exibirBotoes = in_array($_SESSION['nivel'] ?? '', ['admin', 'atendente'], true);
$ehAdmin      = ($_SESSION['nivel'] ?? '') === 'admin';

// P-19: guarded POST access
$encoding = mb_internal_encoding();
$setor    = mb_strtoupper(post_str('setor'), $encoding);
$registros = pegarSetorFuncionario($setor);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar ramal — IPMJP</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="listar-ramais.php">Voltar</a>
                    <a href="../index.php">Home</a>
                    <?php if ($exibirBotoes): ?>
                        <a href="../controle/logoff.php">Sair</a>
                    <?php endif; ?>
                </div>
            </div>

            <div id="area-tabela">
                <?php if (count($registros) === 0): ?>
                    <div class="sem-resultados">
                        Nenhum setor encontrado para a pesquisa.
                        <a href="listar-ramais.php">Limpar filtros</a>
                    </div>
                <?php endif; ?>
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Setor</th>
                            <th>Ramal</th>
                            <th class="email">Responsável</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($registros as $registro): ?>
                            <?php $ramalExibido = ($registro['ramal'] == 0) ? '' : $registro['ramal']; ?>
                            <tr>
                                <td data-label="Setor"><?= e((string)$registro['setor']) ?></td>
                                <td class="center" data-label="Ramal"><span class="ramal-valor"><?= e((string)$ramalExibido) ?></span></td>
                                <td class="email" data-label="Responsável"><?= e((string)($registro['responsavel'] ?? '')) ?></td>

                                <td class="alinhamento-btn" data-label="Ação">
                                    <a class="btn-funcionarios" title="Exibir Funcionários" aria-label="Exibir funcionários do setor <?= e((string)$registro['setor']) ?>" href="listar-funcionarios-com-setor.php?idSetor=<?= (int)$registro['idSetor'] ?>&setor=<?= urlencode((string)$registro['setor']) ?>"></a>

                                    <?php if ($exibirBotoes): ?>
                                        <a class="btn-editar" title="Alterar ramal" aria-label="Alterar ramal do setor <?= e((string)$registro['setor']) ?>" href="form-editar-ramal.php?idSetor=<?= (int)$registro['idSetor'] ?>&setor=<?= urlencode((string)$registro['setor']) ?>&ramal=<?= urlencode((string)$ramalExibido) ?>&responsavel=<?= urlencode((string)($registro['responsavel'] ?? '')) ?>"></a>
                                    <?php endif; ?>

                                    <?php if ($ehAdmin): ?>
                                        <form action="../controle/controle-deletar-ramal.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$registro['setor']) ?> ?');">
                                            <?php echo campo_csrf(); ?>
                                            <input type="hidden" name="idSetor" value="<?= (int)$registro['idSetor'] ?>">
                                            <button type="submit" class="btn-excluir" title="Excluir ramal" aria-label="Excluir ramal do setor <?= e((string)$registro['setor']) ?>"></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>
