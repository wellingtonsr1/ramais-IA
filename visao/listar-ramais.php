<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/controle-listar-ramais.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-36: single source of truth for the button area
$exibirBotoes = in_array($_SESSION['nivel'] ?? '', ['admin', 'atendente'], true);
$ehAdmin      = ($_SESSION['nivel'] ?? '') === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar ramais — IPMJP</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar">
                    <form action="filtrar-ramal.php" method="post" onsubmit="return filtrarTabelaInstantanea('setor', 'msg-sem-resultados') && filtrarTabelaPorRamal('setor', 'msg-sem-resultados');">
                        <?php echo campo_csrf(); ?>
                        <label class="label-campo-busca" for="setor">
                            <span class="label-texto-busca">Setor ou nome</span>
                            <input class="campo-filtrar" type="text" name="setor" id="setor" placeholder="Informe o setor ou nome" autocomplete="off" autocorrect="off" autofocus required
                            oninput="filtrarTabelaInstantanea('setor', 'msg-sem-resultados')" aria-label="Pesquisar por setor ou nome">
                        </label>
                        <label class="label-campo-busca" for="ramal">
                            <span class="label-texto-busca">Ramal</span>
                            <input class="campo-filtrar" type="text" name="ramal" id="ramal" placeholder="Ou apenas o ramal" inputmode="numeric" maxlength="8" autocomplete="off" autocorrect="off"
                            oninput="verificarTextoRamal(); filtrarTabelaPorRamal('setor', 'msg-sem-resultados');" aria-label="Pesquisar pelo número do ramal">
                            <span id="spanRamal" class="nao-visivel" style="font-size:0.8em; margin-left:6px;">Somente números</span>
                        </label>
                        <div class="row-botoes-busca">
                            <button class="btn-filtrar" id="btnBusca" type="submit">Filtrar</button>
                            <button class="btn-limpar-filtro" type="button" onclick="return limparFiltroTabela('setor', 'msg-sem-resultados');">Limpar</button>
                        </div>
                    </form>
                </div>
                <div class="lado-direito-filtrar">
                    <div class="acoes-secundarias">
                        <a href="../modelo/exportar-em-pdf.php" aria-label="Baixar lista de ramais em PDF">Salvar em PDF</a>
                        <?php if ($exibirBotoes): ?>
                            <a href="form-adicionar-ramal.php">Adicionar</a>
                            <a href="../index.php">Home</a>
                            <a href="../controle/logoff.php">Sair</a>
                        <?php else: ?>
                            <a href="login.php">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="area-busca-ativa" class="area-busca-ativa" hidden>
                <span id="busca-ativa-texto"></span>
                <span id="busca-ativa-count" class="busca-ativa-count"></span>
            </div>

            <div id="area-tabela">
                <div id="msg-sem-resultados" class="sem-resultados" hidden>
                    Nenhum setor ou funcionário encontrado.
                    <button class="btn-limpar-filtro" type="button" onclick="return limparFiltroTabela('setor', 'msg-sem-resultados')">Limpar busca</button>
                </div>
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Setor</th>
                            <th class="ramal">Ramal</th>
                            <th class="responsavel">Responsável</th>
                            <th id="acao">Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $listaDeRegistros = pegarListaSetores(); ?>
                        <?php foreach ($listaDeRegistros as $dadosRamal): ?>
                            <?php $ramalExibido = ($dadosRamal['ramal'] == 0) ? '' : $dadosRamal['ramal']; ?>
                            <tr>
                                <td data-label="Setor"><?= e($dadosRamal['setor']) ?></td>
                                <td class="ramal" data-label="Ramal"><span class="ramal-valor"><?= e((string)$ramalExibido) ?></span></td>
                                <td class="responsavel" data-label="Responsável"><?= e((string)($dadosRamal['responsavel'] ?? '')) ?></td>

                                <td class="alinhamento-btn" data-label="Ação">
                                    <a class="btn-funcionarios" title="Exibir Funcionários" aria-label="Exibir funcionários do setor <?= e((string)$dadosRamal['setor']) ?>" href="listar-funcionarios-com-setor.php?idSetor=<?= (int)$dadosRamal['idSetor'] ?>&setor=<?= urlencode((string)$dadosRamal['setor']) ?>"></a>

                                    <?php if ($exibirBotoes): ?>
                                        <a class="btn-editar" title="Alterar ramal" aria-label="Alterar ramal do setor <?= e((string)$dadosRamal['setor']) ?>" href="form-editar-ramal.php?idSetor=<?= (int)$dadosRamal['idSetor'] ?>&setor=<?= urlencode((string)$dadosRamal['setor']) ?>&ramal=<?= urlencode((string)$ramalExibido) ?>&responsavel=<?= urlencode((string)($dadosRamal['responsavel'] ?? '')) ?>"></a>
                                    <?php endif; ?>

                                    <?php if ($ehAdmin): ?>
                                        <!-- P-08: deletion is now a POST form with CSRF -->
                                        <form action="../controle/controle-deletar-ramal.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dadosRamal['setor']) ?> ?');">
                                            <?php echo campo_csrf(); ?>
                                            <input type="hidden" name="idSetor" value="<?= (int)$dadosRamal['idSetor'] ?>">
                                            <button type="submit" class="btn-excluir" title="Excluir ramal" aria-label="Excluir ramal do setor <?= e((string)$dadosRamal['setor']) ?>"></button>
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
    <?php
    if (!empty($_SESSION['status'])) {
        switch ($_SESSION['status']) {
            case 'sucessoDel': ?>
                <script> sucessoDel('listar-ramais.php') </script>
                <?php break;
            case 'erroDel': ?>
                <script> erroDel('listar-ramais.php', 'Erro ao excluir o registro!') </script>
                <?php break;
            case 'sucessoEditar': ?>
                <script> sucessoEditar('listar-ramais.php') </script>
                <?php break;
            case 'erroEditar': ?>
                <script> erroEditar('listar-ramais.php', 'Não foi possível alterar os dados!') </script>
                <?php break;
        }
        unset($_SESSION['status']);
    }
    ?>
</html>
