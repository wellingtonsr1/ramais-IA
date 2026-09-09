<!DOCTYPE html>

<?php 
    //sessão nao foi iniciada?
    if(!isset($_SESSION)) { session_start(); } 
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Mensagem</title>
    </head>
    
    <body>
        <div id="principal">
        <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <?php
                switch ($_GET['msg']) {
                   /* case 'erro': ?>
                        <div class="area-msg">
                            <div class="alerta error">Erro: Verifique os dados e tente novamente.</div>
                            <div class="botoes-rodape-mensagem"><a href='../index.php'>OK</a></div>
                        </div>   
                        <?php break; 

                    case 'erroDelSetor': ?>
                        <div class="area-msg">
                            <div class="alerta error">Erro ao excluir. Setor contém usuários. </div>
                            <div class="botoes-rodape-mensagem"><a href='../index.php'>OK</a></div>
                        </div>   
                        <?php break; 
                    
                    case 'ramalInserido': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Ramal cadastrado com sucesso.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem"><a href='../visao/form-adicionar-ramal.php'>Adiconar</a></div>
                        </div>
                        <?php break; 

                    case 'usuarioInserido': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Usuário cadastrado com sucesso.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem"><a href='../visao/form-adicionar-usuario.php'>Adiconar</a></div>
                        </div>
                        <?php break; */

                    /*case 'ramalAtualizado': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Os dados do ramal foram  atualizados.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem"><a href='../visao/listar-ramais.php'>Exibir Lista</a></div>
                        </div>
                        <?php break; 

                    case 'usuarioAtualizado': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Os dados do usuário foram atualizados.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem"><a href='../visao/listar-usuarios.php'>Exibir Lista</a></div>
                        </div>
                        <?php break; 

                    case 'funcionarioAtualizado': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Os dados do funcionário foram atualizados.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem"><a href='../visao/listar-funcionarios.php'>Exibir Lista</a></div>
                        </div>
                        <?php break; 
                    
                    case 'diferentes': ?>
                        <div class="area-msg">
                            <div class="alerta error">Senhas não conferem.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem" ><a href='form-alterar-senha.php'>Voltar</a></div>
                        </div>
                        <?php break;

                    case 'senha-alterada': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Sua senha foi alterada. Por favor, faça login novamente.</div>
                            <div class="botoes-rodape-mensagem" ><a href='login.php'>OK</a></div>
                        </div>
                        <?php break;*/

                    case 'senha-resetada': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">A senha do usuário foi alterada com sucesso!</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>OK</a></div>
                        </div>
                        <?php break;
                        
                   /* case 'existe': ?>
                        <div class="area-msg">
                            <div class="alerta atencao">Usuário já casdastrado!</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Home</a></div>
                            <div class="botoes-rodape-mensagem" ><a href='../visao/form-adicionar-usuario.php'>Voltar</a></div>
                        </div>
                        <?php break;*/

                    case 'backupRealizado': ?>
                        <div class="area-msg">
                            <div class="alerta sucesso">Backup realizado com sucesso.</div>
                            <div class="botoes-rodape-mensagem" ><a href='../index.php'>Voltar</a></div>
                        </div>
                        <?php break;
                }?>         
            <?php include_once "rodape.php" ?> 
        </div> 
    </body>
</html>