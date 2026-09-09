<!DOCTYPE html>

<?php 
    //sessão nao foi iniciada?
    if(!isset($_SESSION)) {session_start();} 

    //variável de sessão foi definida e está vazia?
    if(!isset($_SESSION['usuario']) && empty($_SESSION['usuario'])){$_SESSION['usuario'] = 'convidado';}
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Início</title> 
    </head>
    
    <body>  
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="menu">
                <div id="divBusca">
                    <form action="exibir-pesquisa-ramal.php" method="post">
                        <input class="search" name="setor" type="text" id="txtBusca" autocomplete="off" autocorrect="off" autofocus required placeholder="Informe o setor"/>
                        <button class="btn-buscar" id="btnBusca">Buscar</button> 
                    </form>
                </div>
                
                <div class="btn-listar-e-login">
                    <a href="listar-ramais.php">Listar ramais</a>
                    <a href="login.php">Login</a>
                </div>     
                <div class="clear"></div> 
            </div>
        </div>
        <?php include_once "rodape.php" ?>
    </body>
</html>