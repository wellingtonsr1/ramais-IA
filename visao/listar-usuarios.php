<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../controle/controle-listar-usuarios.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar usuários</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar">
                    <form action="filtrar-usuario.php" method="post">
                        <?php echo campo_csrf(); ?>
                        <input class="campo-filtrar" type="text" name="usuario" id="usuario"
                        placeholder="Informe o usuário" autocomplete="off" autocorrect="off" autofocus required>
                        <button class="btn-filtrar" id="btnBusca">Filtrar</button>
                    </form>
                </div>
                <div class="lado-direito-filtrar">
                    <div class="formata-btn-home"><a href="../controle/logoff.php">Sair</a> </div>
                    <div class="formata-btn-home"><a href="../index.php">Home</a></div>
                    <div class="formata-btn-home"><a href="form-adicionar-usuario.php">Adicionar</a></div>
                </div>
            </div>

            <div id="area-tabela">
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Nível</th>
                            <th class="email">e-mail</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listaDeRegistros = pegarListaUsuarios(); ?>
                        <?php foreach ($listaDeRegistros as $dadosUsuario): ?>
                            <tr>
                                <td><?= e((string)$dadosUsuario['usuario']) ?></td>
                                <td class="center"><?= e((string)$dadosUsuario['nivel']) ?></td>
                                <td class="email"><?= e((string)($dadosUsuario['email'] ?? '')) ?></td>
                                <td class="alinhamento-btn">
                                    <a class="btn-editar" title="Editar usuário" href="form-editar-usuario.php?id=<?= (int)$dadosUsuario['id'] ?>"></a>
                                    <!-- P-08: deletion is now a POST form with CSRF -->
                                    <form action="../controle/controle-deletar-usuario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dadosUsuario['usuario']) ?> ?', 'Lembre-se: É preciso ao menos um administrador');">
                                        <?php echo campo_csrf(); ?>
                                        <input type="hidden" name="id" value="<?= (int)$dadosUsuario['id'] ?>">
                                        <button type="submit" class="btn-excluir" title="Excluir usuário"></button>
                                    </form>
                                    <a class="btn-alterar-senha" title="Redefinir senha" href="form-redefinir-senha.php?id=<?= (int)$dadosUsuario['id'] ?>"></a>
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
                <script> sucessoDel('listar-usuarios.php') </script>
                <?php break;
            case 'erroDel': ?>
                <script> erroDel('listar-usuarios.php', 'Erro ao excluir o registro!') </script>
                <?php break;
            case 'erroDelAdmin': ?>
                <script> erroDel('listar-usuarios.php', 'Erro: Deve haver ao menos um usuário administrador.') </script>
                <?php break;
            case 'sucessoEditar': ?>
                <script> sucessoEditar('listar-usuarios.php') </script>
                <?php break;
            case 'erroEditar': ?>
                <script> erroEditar('listar-usuarios.php', 'Não foi possível alterar os dados!') </script>
                <?php break;
            case 'erroEditarAdmin': ?>
                <script> erroEditar('listar-usuarios.php', 'Erro: Deve haver ao menos um usuário administrador.') </script>
                <?php break;
            case 'sucessoRedfSenha': ?>
                <script> sucessoEditar('listar-usuarios.php') </script>
                <?php break;
        }
        unset($_SESSION['status']);
    }
    ?>
</html>
