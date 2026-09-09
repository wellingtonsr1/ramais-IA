<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== 'SIM') {
    redirecionar('login.php?login=erro2');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Contato</title>
    </head>

    <body>
        <div id="construcao">
            <img width="800px" src="../imagem/pagina-em-construcao.png" alt="Página em construção"><br><br><br><br>
            <a href="../controle/logoff.php">Sair</a>
            <a href="javascript:history.back()">Voltar</a>
        </div>
    </body>
</html>
