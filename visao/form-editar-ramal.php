<!DOCTYPE html>

<?php 
    require "../controle/validador-acesso.php"; 
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }
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
            <?php include_once "topo.php"; ?>
          
            <div id="formulario-editar-ramal">
                <form method="post" action="../controle/controle-editar-ramal.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"> <a href="../visao/listar-ramais.php">Voltar</a> </div> 
                    <fieldset >
                        <legend><span class="formata-font">Editar ramal</legend>
                        <div><input type="hidden" name="idSetor" id="idSetor" value=<?= $_GET['idSetor'] ?>></div>
                
                        <div id="centro-base">  
                            <div class="lado-esquerdo-editar-ramal">
                                <div>
                                    <label for="setor">Setor <span class="label-asterisco">*</span></label>
                                    <span id='spanSetor' class="nao-visivel" >Ex: SETOR X ou SETOR-X</span>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="setor" id="setor" value="<?= $_GET['setor'] ?>" 
                                    maxlength="35" autocomplete="off" autocorrect="off" placeholder="Informe o setor" required
                                    onkeyup="verificarTextoSetor()">
                                </div>

                                <div>
                                    <label  for="ramal">Ramal <span class="label-asterisco">*</span></label>
                                    <span id='spanRamal' class="nao-visivel" >Informe apenas números</span>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="texto" name="ramal" id="ramal" value="<?= $_GET['ramal'] ?>" 
                                    maxlength="14" autocomplete="off" autocorrect="off" placeholder="Informe o ramal" required
                                    onkeyup="verificarTextoRamal()">
                                </div>
                                
                                <div>
                                    <label for="responsavel">Responsável</label>
                                </div>
                                <div>
                                    <input class="campo-formulario" class="campo-formulario" type="text" name="responsavel" id="responsavel" value="<?= $_GET['responsavel'] ?>"
                                    maxlength="25" autocomplete="off" autocorrect="off" placeholder="Informe o responsavel" autocorrect="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class="clear"></div>
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   

                        <div class="botoes-rodape-editar-ramal">
                            <input class="enviar-submit" type="submit" value="Salvar">
                            <input class="limpar-submit" type="reset" value="Restaurar">
                        </div>
                    </fieldset> 
                </form>
                <?php include_once "rodape.php" ?>
            </div>   
        </div>
    </body>
</html>

