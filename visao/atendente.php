<!DOCTYPE html>

<?php require "../controle/validador-acesso-atendente.php"; ?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Gerente</title>
    </head>
    
    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <nav>  
                <ul id="menu">
                    <li><a href="form-adicionar-ramal.php">Adicionar ramal</a></li>
                    <li><a href="listar-ramais.php">Listar ramais</a></li>
                    <div id="barraDireita">
                        <li >
                            <form action="exibir-pesquisa-ramal.php" method="post">
                                <input type="search" name="setor" class="pesquisar" placeholder="Pesquisar..." >
                            </form>
                        </li>
                    </div>
                                        
                    <div id="user-logado">
                        <li><a href="#"><?= $_SESSION['usuario'] ?></a>
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