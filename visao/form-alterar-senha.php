<!DOCTYPE html>

<?php 
    require "../controle/validador-acesso.php"; 
   
    
    $_SESSION['opcao'] = 'alt'; //o usuário alterou sua senha?
?> 

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Alterar senha</title>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="formulario-alterar-senha">
                <form method="post" action="../controle/controle-atualizar-senha.php">
                    <?php if($_SESSION['primeiroacesso'] != 'sim'){?>
                        <?php if($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente'){?>
                            <div class="formata-btn-home"> <a href="../index.php">Home</a> </div> 
                        <?php } ?>
                    <?php }else{?>
                            <div class="formata-btn-home"> <a href="../controle/logoff.php">Sair</a> </div> 
                    <?php } ?>
                    
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Alterar senha<span></legend>
                        <div><input type="hidden" name="id" id="id" value=<?= $_SESSION['id'] ?>></div>
                        <div class="inputs-alterar-senha">
                            <div>
                                <label for="novaSenha">Nova senha <span class="label-asterisco">*</span></label>
                                <span id='spanNovaSenha' class="nao-visivel">Apenas números, letras e @$&!#%</span>
                            </div>
                            <div>
                                <input class="campo-input" type="password" name="novaSenha" id="novaSenha" placeholder="Informe a senha" 
                                onkeyup="verificarTextoNovaSenha()" required> 
                            </div>

                            <div>    
                                <label for="senhaConfirmada">Confirme a senha <span class="label-asterisco">*</span></label>
                                <span id='spanSenhaConfirmada' class="nao-visivel">Apenas números, letras e @$&!#%</span>
                            </div>
                            <div>
                                <input class="campo-input" type="password" name="senhaConfirmada" id="senhaConfirmada" placeholder="Repita a senha" 
                                onkeyup="verificarTextoSenhaConfirmada()" required> 
                                <button class="btn-senha" type="button" onmousedown="mostrarSenha('novaSenha', 'senhaConfirmada')" onmouseup="mostrarSenha('novaSenha', 'senhaConfirmada')"></button>
                            </div>                           
                        </div>
                        <div><p class="campo-obrigatorio-altera-senha"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   
                        <div class="clear"></div>

                        <div class="botoes-rodape-alterar-senha">
                            <input class="enviar-submit" type="submit" value="Alterar">
                            <input class="limpar-submit" type="reset" value="Limpar">
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
    <?php 
        include "../includes/cdns.php"; 

        if(isset($_SESSION['status']) && !empty($_SESSION['status'])){
            switch ($_SESSION['status']) { 
                case 'sucessoEdtSenha': 
                    session_destroy();?>
                    <script> sucessoSenha('../visao/login.php', 'Senha alterada com sucesso!', 'Faça login novamente!') </script>
                    <?php break;
                case 'senhasDiferentes': ?>
                    <script> erroSenha('Senhas não conferem.') </script>
                    <?php break;
                case 'erroSenha': ?>
                    <script> erroSenha('Há algo errado com as senhas.') </script>
                    <?php break;
            }
            unset($_SESSION['status']);
        }   
    ?>
</html>