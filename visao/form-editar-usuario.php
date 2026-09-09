<!DOCTYPE html>

<?php 
    require "../controle/validador-acesso-admin.php"; 
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }
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

            <div id="formulario-editar-usuario">
                <form method="post" action="../controle/controle-editar-usuario.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"> <a href="../visao/listar-usuarios.php">Voltar</a> </div> 
                    <fieldset>
                        <legend><span class="formata-font">Editar usuário<span></legend>
                        <div><input type="hidden" name="id" id="id" value=<?= $_GET['id'] ?>></div>
  
                        <div class="esquerdo-direito-form-usuario">
                            <div class="lado-esquerdo-form-usuario">
                                <div>
                                    <label for="usuario">Usuário</label>
                                </div>
                                <div >
                                    <input class="campo-formulario" type="text" name="usuario" id="usuario" value="<?= $_GET['usuario'] ?>" readonly>
                                </div>

                            </div>

                            <div class="lado-direito-form-usuario">
                                <div>
                                    <label for="email">E-mail</label>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="email" id="email" value="<?= $_GET['email'] ?>"  placeholder="Informe o novo email">
                                </div>

                                <div>
                                    <label for="nivel">Nivel de acesso <span class="label-asterisco">*</span></label>
                                </div>
                                <div>
                                    <select name="nivel" id="nivel" required>
                                        <option disabled value="">Escolha um nível</option>
                                        <option value="admin" <?= $_GET['nivel'] == 'admin' ? 'selected' : '';?>>Administrador</option>
                                        <option value="atendente" <?= $_GET['nivel'] == 'atendente' ? 'selected' : '';?>>Atentente</option>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>   

                        <div class="botoes-rodape-editar-usuarios">
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