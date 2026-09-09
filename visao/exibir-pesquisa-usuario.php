<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../controle/controle-buscar-usuario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-19: guarded POST access
$usuario = strtolower(post_str('usuario'));
$registros = verificarUsuario($usuario); // P-29: broken inline comment removed
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Pesquisar usuário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php"; ?>

            <div id="menu">
                <div class="lado-direito-filtrar"><a href="../index.php">Home</a></div>
                <div id="area-tabela">
                    <table class="table-container">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Nível</th>
                                <th>e-mail</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registros as $dados): ?>
                                <tr>
                                    <td><?= e((string)$dados['usuario']) ?></td>
                                    <td class="center"><?= e((string)$dados['nivel']) ?></td>
                                    <td class="center"><?= e((string)($dados['email'] ?? '')) ?></td>

                                    <td class="alinhamento-btn">
                                        <a class="btn-editar" title="Editar usuário" aria-label="Editar usuário <?= e((string)$dados['usuario']) ?>" href="form-editar-usuario.php?id=<?= (int)$dados['id'] ?>"></a>
                                        <form action="../controle/controle-deletar-usuario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$dados['usuario']) ?> ?', '');">
                                            <?php echo campo_csrf(); ?>
                                            <input type="hidden" name="id" value="<?= (int)$dados['id'] ?>">
                                            <button type="submit" class="btn-excluir" title="Excluir usuário" aria-label="Excluir usuário <?= e((string)$dados['usuario']) ?>"></button>
                                        </form>
                                        <a class="btn-alterar-senha" title="Redefinir senha" aria-label="Redefinir senha do usuário <?= e((string)$dados['usuario']) ?>" href="form-redefinir-senha.php?id=<?= (int)$dados['id'] ?>"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php include_once "rodape.php" ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </body>
    <?php include "../includes/cdns.php"; // Swal for the delete confirmation ?>
</html>
