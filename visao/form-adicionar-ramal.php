<!DOCTYPE html>

<?php  
    require "../controle/validador-acesso.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){header('Location: form-alterar-senha.php');}
?> 

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Adicionar ramal</title>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="formulario-cadastro">
                <form method="post" action="../controle/controle-adicionar-ramal.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div> 
                    <div class="formata-btn-home"> <a href="" onclick="abrirPopup()">Organograma</a> </div>
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Adicionar ramal</legend>
                        <div class="lado-esquerdo">
                            <div>
                                <label for="setor">Setor <span class="label-asterisco">*</span></label>
                                <span id='spanSetor' class="nao-visivel">Ex: Setor, Setor - X ou Setor de Arquivo</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="setor" id="setor" maxlength="35" 
                                autocomplete="off" autocorrect="off" placeholder="Informe o setor" autofocus required 
                                onkeyup="verificarTextoSetor()">
                            </div>

                            <div>
                                <label for="ramal">Ramal <span class="label-asterisco">*</span></label>
                                <span id='spanRamal' class="nao-visivel">Informe apenas números</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="texto" name="ramal" id="ramal"  maxlength="14" 
                                autocomplete="off" autocorrect="off" placeholder="Informe o ramal" required 
                                onkeyup="verificarTextoRamal()">
                            </div> 
                        </div>

                        <div class="lado-direito">
                            <div>
                                <label for="responsavel">Responsável <span class="label-asterisco">*</span></label>
                                <span id='spanResponsavel' class="nao-visivel" >Ex: João silva</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="responsavel" value='NÃO INFORMADO' id="responsavel" maxlength="25" autocomplete="off" 
                                autocorrect="off" placeholder="Informe o responsável" required
                                onkeyup="verificarTextoResponsavel()">
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   

                        <div class="botoes-rodape-ramal">
                
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
        include "../includes/cdns.php"; 

        if(isset($_SESSION['status']) && !empty($_SESSION['status'])){
            switch ($_SESSION['status']) { 
                case 'sucessoAdd': ?>
                    <script> sucessoAdd('ramal') </script>  
                    <?php break;
                case 'erroAdd': ?>
                    <script> erroAdd('ramal', 'Não foi possível salvar os dados!') </script>  
                    <?php break;
            }
            unset($_SESSION['status']);
        }
    ?>
</html>