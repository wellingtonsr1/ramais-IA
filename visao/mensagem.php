<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Mensagem</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <?php switch (get_str('msg')):
                case 'senha-resetada': ?>
                    <div class="area-msg">
                        <div class="alerta sucesso">A senha do usuário foi alterada com sucesso!</div>
                        <div class="botoes-rodape-mensagem"><a href="../index.php">OK</a></div>
                    </div>
                    <?php break;

                case 'backupRealizado': ?>
                    <div class="area-msg">
                        <div class="alerta sucesso">Backup realizado com sucesso.</div>
                        <div class="botoes-rodape-mensagem"><a href="../index.php">Voltar</a></div>
                    </div>
                    <?php break;

                case 'erroBackup': ?>
                    <div class="area-msg">
                        <div class="alerta error">Não foi possível realizar o backup. Contate o administrador.</div>
                        <div class="botoes-rodape-mensagem"><a href="../index.php">Voltar</a></div>
                    </div>
                    <?php break;

                default: ?>
                    <div class="area-msg">
                        <div class="alerta atencao">Mensagem desconhecida.</div>
                        <div class="botoes-rodape-mensagem"><a href="../index.php">Voltar</a></div>
                    </div>
                    <?php break;
            endswitch; ?>

            <?php include_once "rodape.php" ?>
        </div>
    </body>
</html>
