<!DOCTYPE html>

<?php
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); } 

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    include "../controle/controle-buscar-ramal.php";
    
    //a sessão é o admim ou atendente?
    $exibirBotoes = FALSE;
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){ $exibirBotoes = TRUE; }   
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Pesquisar ramal</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                    <a href="../index.php">Home</a> 
                    <a href="listar-ramais.php">Exibir lista</a>
                </div>    
            </div>

           <div id="area-tabela">
                <table class="table-container"> 
                    <thead>
                        <tr>  
                            <th>Setor</th> 
                            <th>Ramal</th>
                            <th class="email"s>Responsável</th>
                            <?php  if($exibirBotoes){ ?>
                                <th>Ação</th> 
                            <?php } ?>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            $setor = mb_strtoupper($_POST['setor']);
                            $registro = pegarListaSetores($setor);

                            if(isset($registro) && !empty($registro)){ ?>
                                <?php foreach($registro as $linha){
                                    $dados = $linha;?>
                                    <tr> 
                                        <td><?= $dados['setor'] ?></td>
                                        <td class="center"><?= $dados['ramal'] ?></td>
                                        <td class="email"><?= $dados['responsavel'] ?></td> 
                                        
                                        <td class="alinhamento-btn"> 
                                        <a class="btn-funcionarios" title='Exibir Funcionários' href="../visao/listar-funcionarios-com-setor.php?idSetor=<?= $dados['idSetor'] ?>&setor=<?= $dados['setor'] ?>"></a> 
                                        <?php  if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){ ?>
                                            <a class="btn-editar" onClick="confirmarEdicao(event,  ' <?= $dados['setor'] ?>')" title='Alterar ramal' href="form-editar-ramal.php?idSetor=<?= $dados['idSetor'] ?>&setor=<?= $dados['setor'] ?>&ramal=<?= $dados['ramal'] ?>&responsavel=<?= $dados['responsavel'] ?>"></a> 
                                            <?php  if($_SESSION['nivel'] == 'admin'){ ?>
                                                <a class="btn-excluir" onClick="confirmarExclusao(event, 'Deseja realmente excluir <?= $dados['setor'] ?> ?', '')" title='Excluir ramal' href="../controle/controle-deletar-ramal.php?idSetor=<?= $dados['idSetor'] ?>&setor=<?= $dados['setor'] ?>"></a> 
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                    </tr> 
                                <?php  }?>  
                            <?php  }?> 
                    </tbody>  
                </table> 
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>