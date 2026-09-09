<!DOCTYPE html>

<?php 
    require "../controle/validador-acesso-admin.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }

    $_SESSION['opcao'] = 'reset'; //senha do usuário foi redefinida?
   
   
?> 

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Redefinir senha</title>
    </head>

    <body>
        
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="formulario-alterar-senha">
                <form method="post" action="../controle/controle-atualizar-senha.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div> 
                    <div class="formata-btn-home"> <a href="../visao/listar-usuarios.php">Voltar</a> </div> 
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Redefinir senha<span></legend>
                        <div>
                            <input type="hidden" name="id" id="id" value=<?= $_GET['id'] ?>>
                        </div>
                
                        <div>
                            <input type="hidden" name="usuario" id="usuario" value=<?= $_GET['usuario'] ?>>
                        </div>

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
                            <div>
                                <input type="checkbox" id="primeiroacesso" name="primeiroacesso" value="sim"> Usuário deve alterar a senha.                          
                            </div>
                            
                        </div>
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   
                        <div class="clear"></div>

                        <div class="botoes-rodape-redefinir-senha">
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
                case 'sucessoRedfSenha': ?>
                    <script> sucessoSenha('../index.php', 'A Senha do usuário foi alterada com sucesso!', '') </script>
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