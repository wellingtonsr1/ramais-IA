<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
cabecalhos_seguranca();?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Login</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-login">
                <form action="../controle/controle-valida-login.php" method="post">
                    <?php echo campo_csrf(); // P-07 ?>
                    <fieldset>
                        <legend><span class="formata-font">Área de login</span></legend>
                        <div class='campos-login'>
                            <div>
                                <input class="usuario" type="text" name="usuario" id="usuario" autocomplete="off" autocorrect="off" autofocus placeholder="Digite seu usuário">
                            </div>

                            <div>
                                <input class="senha" type="password" name="senha" id="senha" placeholder="Digite sua senha">
                                <button class="btn-senha" type="button" onclick="mostrarSenha('senha')"></button>
                            </div>

                            <?php if (isset($_GET['login']) && $_GET['login'] === 'erro'): ?>
                                <div class="text-danger" role="alert">
                                    Usuário ou senha inválido(s)
                                </div>
                            <?php elseif (isset($_GET['login']) && $_GET['login'] === 'erro2'): ?>
                                <div class="text-danger" role="alert">
                                    Sessão expirada ou inválida. Faça login novamente.
                                </div>
                            <?php elseif (isset($_GET['senha']) && $_GET['senha'] === 'alterada'): ?>
                                <div class="text-success" role="alert">
                                    Senha alterada com sucesso. Faça login novamente.
                                </div>
                            <?php endif; ?>

                            <div class="botoes-rodape-login">
                                <input class="btn-logar" type="submit" value="Logar">
                                <input class="btn-cancelar" type="button" value="Cancelar" onclick="location.href='../controle/logoff.php'">
                            </div>
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div>

    </body>
</html>
