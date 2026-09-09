<!DOCTYPE html>

<?php 
    require "../controle/validador-acesso-admin.php"; 

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){header('Location: form-alterar-senha.php');}
?> 

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Adicionar usuário</title>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="formulario-cadastro">
                <form method="post" action="../controle/controle-adicionar-usuario.php">
                    <div class="formata-btn-home"><a href="../index.php">Home</a> </div> 
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Adicionar usuário<span></legend>
                        <div class="lado-esquerdo">
                            <div>
                                <label for="usuario">Usuário <span class="label-asterisco">*</span></label>
                                <span id='spanUsuario' class="nao-visivel" >Ex: joao.silva ou joaosilva</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="usuario" id="usuario" maxlength="25" 
                                autocomplete="off" autocorrect="off" autofocus placeholder="Informe o usuário" required
                                onkeyup="verificarTextoUsuario()">
                            </div>

                            <div>
                                <label for="senha">Senha <span class="label-asterisco">*</span></label> 
                                <span id='spanSenha' class="nao-visivel" >Apenas números, letras e @$&!#%</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="password" name="senha" id="senha" maxlength="20" placeholder="Informe a senha" required
                                onkeyup="verificarTextoSenha()" > 
                                <button class="btn-senha" type="button" onmousedown="mostrarSenha('senha')" onmouseup="mostrarSenha('senha')"></button>
                            </div>   
                            <div class="checkbox">
                                <label><input type="checkbox" id="primeiroacesso" name="primeiroacesso" value="sim"> Usuário deve alterar a senha.</label>
                            </div>   
                        </div>
                        
                        <div class="lado-direito">
                            <div>
                                <label for="email">E-mail:</label> 
                            </div>
                            <div>
                                <input class="campo-formulario" type="email" name="email" id="email" maxlength="40" 
                                autocomplete="off" autocorrect="off" placeholder="Ex: joao@empresa.com.br">
                            </div>

                            <div>
                                <label for="nivel">Nivel de acesso <span class="label-asterisco">*</span></label>
                            </div>
                            <div>
                                <select name="nivel" id="nivel" required>
                                    <option selected disabled value="">Escolha um nível</option>
                                    <option value="admin">Administrador</option>
                                    <option value="atendente">Atentente</option>
                                </select> 
                            </div>
                        </div>
                        
                        <div class="clear"></div>
                        
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   

                        <div class="botoes-rodape-usuarios">
                            <input class="enviar-submit" type="submit" value="Salvar">
                            <input class="limpar-submit" type="reset" value="Limpar">
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div> 
    </body>
    <?php 
        if(isset($_SESSION['status']) && !empty($_SESSION['status'])){
            include "../includes/cdns.php"; 

            switch ($_SESSION['status']) { 
                case 'sucessoAdd': ?>
                    <script> sucessoAdd('usuario') </script>  
                    <?php break;
                case 'erroAdd': ?>
                    <script> erroAdd('usuario', 'Não foi possível salvar os dados!') </script> 
                    <?php     break;
                case 'erroAddExiste':?>
                    <script> erroAdd('usuario', 'Usuário já cadastrado.') </script>
                    <?php    break;
            }
            unset($_SESSION['status']);
        }
    ?>
</html>