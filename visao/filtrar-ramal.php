<!DOCTYPE html>

<?php
    include "../controle/controle-setor-funcionario.php";
    
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); }
     
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }
    
    //a sessão é do admim ou atendente?
    $exibirBotoes = FALSE;
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){
        $exibirBotoes = TRUE;
    }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar ramal</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>
    
    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-direito-filtrar">
                <a href="listar-ramais.php">Voltar</a>
                    <a href="../index.php">Home</a>
                    <!--<a href="listar-ramais.php">Exibir lista</a>-->
                    <?php  if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){ ?>
                               <a href="../controle/logoff.php">Sair</a> 
                    <?php } ?>  
                </div>    
            </div>

            <div id="area-tabela">
                <table class="table-container"> 
                    <thead>
                        <tr>  
                            <th>Setor</th> 
                            <th>Ramal</th>
                            <th class="email">Responsável</th>
                            <th>Ação</th> 
                        </tr> 
                    </thead>  

                    <tbody>
                        <?php 
                            //converte o valor passado em '$_POST['setor']' para maiúscula
                            //mb_strtoupper
                            $encoding = mb_internal_encoding(); 
                            $setor = mb_strtoupper($_POST['setor'], $encoding);

                            //$listaDeRegistros = pegarListaSetores();
                            //$listaDeRegistros = pegarListaFuncionarios($setor);
                            $listaDeRegistros = pegarSetorFuncionario($setor);
                          
                            foreach(/*$_SESSION['arraySetores']*/$listaDeRegistros as $linha){
                                $registro = $linha;
                               
                                if((isset($registro) && !empty($registro) /*&& (preg_match("/\A$setor/", $registro['setor']))*/)){?>  
                                    <tr> 
                                        <td><?= $registro['setor'] ?></td>

                                        <?php //$registro['ramal'] = $registro['ramal'] == 0 ? '' : $registro['ramal'];?>
                                        <td class="center"><?= $registro['ramal'] = $registro['ramal'] == 0 ? '' : $registro['ramal'] //$registro['ramal'] ?></td>

                                        <td class="email"><?= $registro['responsavel'] ?></td>  
                                        
                                        <td class="alinhamento-btn"> 
                                            <a class="btn-funcionarios" title='Exibir Funcionários' href="../visao/listar-funcionarios-com-setor.php?idSetor=<?= $registro['idSetor'] ?>&setor=<?= $registro['setor'] ?>"></a> 
                                            <!--exibirBotoes é TRUE?-->
                                            <?php if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){ ?> 
                                                <a class="btn-editar" onClick="confirmarEdicao(event,  ' <?= $registro['setor'] ?>')" title='Alterar ramal' href="form-editar-ramal.php?idSetor=<?= $registro['idSetor'] ?>&setor=<?= $registro['setor'] ?>&ramal=<?= $registro['ramal'] ?>&responsavel=<?= $registro['responsavel'] ?>"></a> 
                                                <?php if($_SESSION['nivel'] == 'admin'){ ?>
                                                    <a class="btn-excluir" onClick="confirmarExclusao(event, 'Deseja realmente excluir <?= $registro['setor'] ?> ?', '')" title='Excluir ramal' href="../controle/controle-deletar-ramal.php?idSetor=<?= $registro['idSetor'] ?>&setor=<?= $registro['setor'] ?>"></a> 
                                                <?php } ;?>
                                            <?php }; ?>
                                        </td>
                                    </tr> 
                                <?php } ;?>
                        <?php } ;?> 
                    </tbody>
                </table> 
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>