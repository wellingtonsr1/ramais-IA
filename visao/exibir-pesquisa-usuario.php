<!DOCTYPE html>

<?php
    require "../controle/validador-acesso-admin.php";
    include_once "../controle/controle-buscar-usuario.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Pesquisar usuário</title>
    </head>
    
    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ;?>

            <div id="menu"> 
                <div class="lado-direito-filtrar"><a href="../index.php">Home</a></div> 
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
                        <?php
                            $usuario = strtolower($_POST['usuario']);
                            
                            //$registro é um obj, e não um array..por isso usar o '->' para acessar o valor
                            $registro = verificarUsuario($usuario);
                            
                            //if(isset($registro->usuario) || !empty($registro->usuario) && $registro->usuario == $usuario){ ?>
                            <?php foreach($registro as $linha){
                                $dados = $linha;?>
                                <tr> 
                                    <td><?= $dados['usuario'] ?></td>
                                    <td class="center"><?= $dados['nivel'] ?></td>
                                    <td class="center"><?= $dados['email'] ?></td> 
                                    
                                    <td class="alinhamento-btn"> 
                                        <a class="btn-editar" title='Editar usuário' href="form-editar-usuario.php?id=<?= $dados['id'] ?>&usuario=<?= $dados['usuario'] ?>&nivel=<?= $dados['nivel'] ?>&email=<?= $dados['email'] ?>"></a> 
                                        <a class="btn-excluir" title='Excluir usuário' href="../controle/controle-deletar-usuario.php?id=<?= $dados['id'] ?>"></a>
                                        <a class="btn-alterar-senha" title='Redefinir senha' href="form-redefinir-senha.php?id=<?= $dados['id'] ?>&usuario=<?= $dados['usuario'] ?>"></a> 
                                    </td> 
                                </tr>
                            <?php } ?> 
                    </tbody>
                </table> 
                <?php include_once "rodape.php" ?>
            </div>
            <div class="clear"></div> 
            </div>
        </div>
    </body>
</html>