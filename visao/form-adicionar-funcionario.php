<!DOCTYPE html>

<?php 
    require "../controle/controle-listar-ramais.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){header('Location: form-alterar-senha.php');}
    include "../includes/cdns.php"; 
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
                <form method="post" action="../controle/controle-adicionar-funcionario.php">
                    <div class="formata-btn-home"><a href="../index.php">Home</a> </div> 
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Adicionar Funcionário<span></legend>
                        <div class="lado-esquerdo">
                            <div>
                                <label for="nome">Nome <span class="label-asterisco">*</span></label>
                                <span id='spanFuncionario' class="nao-visivel" >Ex: João, João Silva ou João da Silva</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="nome" id="nome" maxlength="25" 
                                autocomplete="off" autocorrect="off" autofocus placeholder="Informe um nome" required
                                onkeyup="verificarTextoFuncionario()">
                            </div>

                            <div>
                                <label for="telefone">Celular</label>
                                <span id='spanTelefone' class="nao-visivel" >Ex: (99) 99999-9999</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="telefone" id="telefone" maxlength="25" 
                                autocomplete="off" autocorrect="off" autofocus placeholder="(99) 99999-9999 (apenas números)"
                                onkeyup="verificarTextoTelefone()">
                            </div>
                        </div>
                        
                        <div class="lado-direito">
                            <div>
                                <label for="nivel">Setor<span class="label-asterisco">*</span></label>
                            </div>
                            <div>
                            <select name="idSetor" id="idSetor" required>
                                    <option selected disabled value="">Escolha um setor</option>
                                    <!-- $_GET's passados por 'listar-funcionario-por-setor' quando clicado em 'Adicionar'-->
                                    <?php if(!isset($listaDeRegistros) && !empty($listaDeRegistros = pegarListaSetores())){ 
                                        foreach($listaDeRegistros as $linha){
                                            $dadosSetor = $linha;
                                            if($dadosSetor['setor'] == $_GET['setor']){?>  
                                                <option selected  value=<?= $dadosSetor['idSetor'] ?>> <?= $dadosSetor['setor'] ?></option>  
                                            <?php }else{ ?>
                                                <option value=<?= $dadosSetor['idSetor'] ?>> <?= $dadosSetor['setor'] ?></option>
                                            <?php } ;?>
                                        <?php } ;?>  
                                    <?php } ;?> 
                                </select> 
                            </div>
                        </div>
                        
                        <div class="clear"></div>
                        
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   

                        <div class="botoes-rodape-funcionarios">
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
                    <script> sucessoAdd('funcionario') </script>
                    <?php break;
                case 'erroAdd': ?>
                    <script> erroAdd('funcionario', 'Não foi possível salvar os dados!') </script> 
                    <?php break;
            }
            unset($_SESSION['status']);
        }   
        
    ?>
    <!-- monta a máscara do telefone -->
    <script type="text/javascript">
        $("#telefone").mask("(00) 00000-0000");
    </script>
</html>