<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso-atendente.php';
cabecalhos_seguranca();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Gerente</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <nav>
                <ul id="menu">
                    <li><a href="form-adicionar-ramal.php">Adicionar ramal</a></li>
                    <li><a href="listar-ramais.php">Listar ramais</a></li>
                    <div id="barraDireita">
                        <li>
                            <form action="exibir-pesquisa-ramal.php" method="post">
                                <?php echo campo_csrf(); ?>
                                <input type="search" name="setor" class="pesquisar" placeholder="Pesquisar...">
                            </form>
                        </li>
                    </div>

                    <div id="user-logado">
                        <li><a href="#"><?= e((string)$_SESSION['usuario']) ?></a>
                            <ul>
                                <li><a href="form-alterar-senha.php">Alterar senha</a>
                                <li><a href="../controle/logoff.php">Sair</a></li>
                            </ul>
                        </li>
                    </div>
                </ul>
            </nav>

            <div class="clear"></div>
        </div>
        <?php include_once "rodape.php" ?>
    </body>
</html>
