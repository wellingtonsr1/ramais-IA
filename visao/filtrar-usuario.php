<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso-admin.php'; // P-03: guard was missing
require_once __DIR__ . '/../controle/controle-buscar-usuario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-13: the filter now runs in the DATABASE (LIKE prefix) instead of a
// preg_match with the user input interpolated into the regex pattern.
// P-18: no more $_SESSION['arrayUsuarios'] (it was unset inside the loop).
$usuario = strtolower(post_str('usuario'));
$registros = ($usuario !== '') ? verificarUsuario($usuario) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar usuário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="../index.php">Home</a>
                    <a href="listar-usuarios.php">Exibir lista</a>
                    <a href="../controle/logoff.php">Sair</a>
                </div>
            </div>

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
                        <?php foreach ($registros as $registro): ?>
                            <tr>
                                <td><?= e((string)$registro['usuario']) ?></td>
                                <td class="center"><?= e((string)$registro['nivel']) ?></td>
                                <td class="center"><?= e((string)($registro['email'] ?? '')) ?></td>

                                <td class="alinhamento-btn">
                                    <a class="btn-editar" title="Editar usuário" aria-label="Editar usuário <?= e((string)$registro['usuario']) ?>" href="form-editar-usuario.php?id=<?= (int)$registro['id'] ?>"></a>
                                    <form action="../controle/controle-deletar-usuario.php" method="post" class="form-del" onsubmit="return confirmarExclusaoForm(event, 'Deseja realmente excluir <?= e((string)$registro['usuario']) ?> ?', '');">
                                        <?php echo campo_csrf(); ?>
                                        <input type="hidden" name="id" value="<?= (int)$registro['id'] ?>">
                                        <button type="submit" class="btn-excluir" title="Excluir usuário" aria-label="Excluir usuário <?= e((string)$registro['usuario']) ?>"></button>
                                    </form>
                                    <a class="btn-alterar-senha" title="Redefinir senha" aria-label="Redefinir senha do usuário <?= e((string)$registro['usuario']) ?>" href="form-redefinir-senha.php?id=<?= (int)$registro['id'] ?>"></a>
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
