<!DOCTYPE html>

<?php  
    //require "../controle/validador-acesso-admin.php"; 
    //require "../controle/controle-listar-funcionarios.php";
    include "../controle/controle-setor-funcionario.php";

    //sessão nao foi iniciada?
    if(!isset($_SESSION)) { session_start(); }

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){
        header('Location: form-alterar-senha.php');
    }  

    //a sessão é do admim ou atendente?
    $exibirBotoes = FALSE; 
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){$exibirBotoes = TRUE; }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Filtrar Funcionário</title>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="area-filtrar">               
                <div class="lado-direito-filtrar">
                    <?php //o botão 'sair' só aparecerá se o usário for o admin ou atendente 
                        if(isset($_SESSION['nivel']) == 'admin' || isset($_SESSION['nivel']) == 'atendente'){ ?>
                            <a href="form-adicionar-funcionario.php">Adicionar</a> 
                    <?php } ?>
                    <a href="../index.php">Home</a>
                    <?php  //o botão 'sair' só aparecerá se o usário for o admin ou atendente 
                        if(isset($_SESSION['nivel']) == 'admin' || isset($_SESSION['nivel']) == 'atendente'){ ?>
                            <a href="../controle/logoff.php">Sair</a>     
                    <?php } ?>
                </div>    
            </div>
            
            <div id="area-tabela">
                <table class="table-container">
                    <thead>
                        <tr> 
                            <th>Funcionário</th>
                            <th>Setor</th>
                            <th>Telefone</th>
                           <!-- <th>e-mail</th>-->
                            <?php  if($exibirBotoes){ ?>
                                <th>Ação</th> 
                            <?php } ?> 
                        </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            //converte o valor passado em '$_POST['nome']' para maiúscula//mb_strtoupper(
                            $nome = mb_strtoupper($_POST['nome']);
                            
                            if(isset($_SESSION['arrayFuncionarios']) && !empty($_SESSION['arrayFuncionarios'])){ 
                                foreach($_SESSION['arrayFuncionarios'] as $linha){ 
                                    $dadosFuncionario = $linha; 
                                   
                                    if(isset($dadosFuncionario) && !empty($dadosFuncionario) && preg_match("/\A$nome/",  $dadosFuncionario['nome'])){?>
                                        <tr> 
                                            <td ><?= $dadosFuncionario['nome'] ?></td>
                                            <td class="center"><?= $dadosFuncionario['setor'] ?></td>

                                            <?php // coloca a máscara no número do telefone para exibição
                                            if(strlen($dadosFuncionario['telefone']) == 10){
                                                $novo = substr_replace($dadosFuncionario['telefone'], '(', 0, 0);
                                                $novo = substr_replace($novo, '9', 3, 0);
                                                $novo = substr_replace($novo, ')', 3, 0);
                                                $novo = substr_replace($novo, '-', 9, 0);
                                                $novo = substr_replace($novo, ' ', 4, 0);
                                            }else{
                                                $novo = substr_replace($dadosFuncionario['telefone'], '(', 0, 0);
                                                $novo = substr_replace($novo, ')', 3, 0);
                                                $novo = substr_replace($novo, '-', 9, 0);
                                                $novo = substr_replace($novo, ' ', 4, 0);
                                            }  
                                            $dadosFuncionario['telefone'] = $novo;?>
                                            <td class="center"><?= $dadosFuncionario['telefone'] ?></td>
                                        
                                            <?php  if($exibirBotoes){ ?> 
                                                <td class="alinhamento-btn">   
                                                    <a class="btn-editar" title='Editar funcionário' href="form-editar-funcionario.php?idFunc=<?= $dadosFuncionario['idFunc']?>&nome=<?= $dadosFuncionario['nome'] ?>&setor=<?= $dadosFuncionario['setor'] ?>&telefone=<?= $dadosFuncionario['telefone'] ?>"></a> 
                                                    <a class="btn-excluir" title='Excluir funcionário' href="../controle/controle-deletar-funcionario.php?idFunc=<?= $dadosFuncionario['idFunc'] ?>"></a>  
                                                </td> 
                                            <?php } ?>
                                        </tr> 
                                    <?php } 
                                    //unset($_SESSION['arrayFuncionarios']) ?>
                                <?php } ;?>  
                            <?php } ;?>
                    </tbody>
                </table>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>