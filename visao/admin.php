<!DOCTYPE html>

<?php require "../controle/validador-acesso-admin.php";?> 

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Administrador</title>  
    </head>
    
    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ;?>
            
            <nav>  
                <ul id="menu">
                    <li><a href="#">Ramal</a>
                        <ul>
                            <li><a href="form-adicionar-ramal.php">Adicionar</a></li>
                            <li><a href="listar-ramais.php">Listar</a></li>
                            <li>
                                <form action="exibir-pesquisa-ramal.php" method="post">
                                    <input type="search" name="setor" class="pesquisar" placeholder="Pesquisar..." >
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                    <li><a href="#">Funcionário</a>
                        <ul>
                            <li><a href="form-adicionar-funcionario.php">Adicionar</a></li>
                            <li><a href="listar-funcionarios.php">Listar</a></li>
                            <li>
                                <form action="exibir-pesquisa-funcionario.php" method="post">
                                    <input type="search" name="nome" class="pesquisar" placeholder="Pesquisar...">
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li><a href="#">Usuário do sistema</a>
                        <ul>
                            <li><a href="form-adicionar-usuario.php">Adicionar</a></li>
                            <li><a href="listar-usuarios.php">Listar</a></li>
                            <li>
                                <form action="exibir-pesquisa-usuario.php" method="post">
                                    <input type="search" name="usuario" class="pesquisar" placeholder="Pesquisar...">
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                    <div  id="user-logado">
                        <li><a href="#"><?= $_SESSION['usuario'] ?></a>
                            <ul>
                                <li><a href="form-alterar-senha.php">Alterar senha</a>
                                <li>
                                    <a href="../controle/logoff.php">Sair</a>
                                </li>
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