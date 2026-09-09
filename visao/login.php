<!DOCTYPE html>
<?php  
  //sessão não foi iniciada?
  if(!isset($_SESSION)) { session_start(); }
    session_destroy(); 
    ?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Login</title>
           
       <!-- <script src="../js/funcoes.js"></script>-->
    </head>

    <body>
        
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
   
            <div id="formulario-login">
                <form action="../controle/controle-valida-login.php" method="post">
                    <fieldset>
                        <legend><span class="formata-font">Área de login</span></legend>
                        <div class='campos-login'>
                            <div>
                                <input class="usuario" type="text" name="usuario" id="usuario" autocomplete="off" autocorrect="off" autofocus placeholder="Digite seu usuário">
                            </div>

                            <div>
                                <input class="senha" type="password" name="senha" id="senha" placeholder="Digite sua senha"> 
                                <button class="btn-senha" type="button" onmousedown="mostrarSenha('senha')" onmouseup="mostrarSenha('senha')"></button>
                            </div>
                            
                            <?php if(isset($_GET['login']) && $_GET['login'] == 'erro'){ ?>
                                <div class="text-danger">
                                    Usuário ou senha inválido(s)
                                </div>
                            <?php } ?>
                            
                            <div class="botoes-rodape-login">
                                <input class="btn-logar" type="submit" value="Logar">
                                <input class="btn-cancelar" type="submit" value="Cancelar" formaction="../controle/logoff.php">
                            </div>
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div> 
        
    </body>
</html>