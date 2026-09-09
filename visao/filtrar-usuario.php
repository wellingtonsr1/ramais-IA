<!DOCTYPE html>

<?php
    require "../controle/validador-acesso-admin.php";
   
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }

    //a sessão é do admim ou atendente?
    $exibirBotoes = FALSE;
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){$exibirBotoes = TRUE;}   
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar usuário</title>
    </head>
    
    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="../index.php">Home</a> 
                    <a href="listar-usuarios.php">Exibir lista</a>
                    <?php  if($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente'){ ?>     
                                <a href="../controle/logoff.php">Sair</a>   
                    <?php } ?>    
                </div>    
            </div>

            <div id="area-tabela">
                <table class="table-container"> 
                    <thead>
                        <tr> 
                            <th>Usuário</th>
                            <th>Nível</th>
                            <th>e-mail</th>
                            <th>Ação</th> 
                        </tr> 
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION['arrayUsuarios'] as $linha){
                            $registro = $linha;

                            $usuario = strtolower($_POST['usuario']);

                            // 'preg_match("/\A$usuario/"...' Faz uma comparação usando apenas a parte inicial da palavra usando Regex (\A)
                            if((isset($registro) && !empty($registro)) && (preg_match("/\A$usuario/", $registro['usuario']))){ ?>
                                <tr> 
                                    <td><?= $registro['usuario'] ?></td>
                                    <td class="center"><?= $registro['nivel'] ?></td>
                                    <td class="center"><?= $registro['email'] ?></td>  

                                    <?php  if($exibirBotoes){ ?>
                                        <td class="alinhamento-btn"> 
                                            <a class="btn-editar" href="form-editar-usuario.php?id=<?= $registro['id'] ?>&usuario=<?= $registro['usuario'] ?>&nivel=<?= $registro['nivel'] ?>&email=<?= $registro['email'] ?>"></a> 
                                            <a class="btn-excluir" href="../controle/controle-deletar-usuario.php?id=<?= $registro['id'] ?>"></a> 
                                            <a class="btn-alterar-senha" href="form-redefinir-senha.php?id=<?= $registro['id']?>&usuario=<?= $registro['usuario'] ?>"></a> 
                                        </td>  
                                    <?php } ?>
                                </tr> 
                            <?php } 
                            unset($_SESSION['arrayUsuarios']) ?>
                        <?php } ?> 	
                    </tbody>			
                </table> 
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>