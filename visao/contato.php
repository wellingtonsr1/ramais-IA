<!DOCTYPE html>

<?php
    if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){ header('Location: login.php?login=erro2'); }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Contato</title>
    </head>
    
    <body>
        <div id="construcao">
            <img width="800px" src="../imagem/pagina-em-construcao.png" alt=""></br></br></br></br>
            <a href="../controle/logoff.php">Sair</a>
            <a href="javascript:history.back()">Voltar</a>
        </div>
    </body>
</html>