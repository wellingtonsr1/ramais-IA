<!DOCTYPE html>

<?php  
    //require "../controle/validador-acesso-admin.php"; 
    require "../controle/controle-listar-funcionarios-por-setor.php";

    //sessão nao foi iniciada?
    if(!isset($_SESSION)) { session_start(); }

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){
        header('Location: form-alterar-senha.php');
    }  

    //a sessão é do admim ou atendente?
    $exibirBotoes = FALSE; 
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' /*|| $_SESSION['nivel'] == 'atendente')*/)){$exibirBotoes = TRUE; }
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar Funcionários</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar"> 
                    <form action="filtrar-funcionario.php" method="post">        
                        <input class="campo-filtrar" type="text" name="nome" id="nome" placeholder="Informe o nome"
                        autocomplete="off" autocorrect="off" autofocus required>
                        <button class="btn-filtrar" id="btnBusca">Filtrar</button> 
                    </form>
                </div> 
                
                <div class="lado-direito-filtrar">
                    <a href="listar-ramais.php">Voltar</a> 
                    <?php //o botão 'sair' só aparecerá se o usário for o admin ou atendente 
                        if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'admin' /*|| isset($_SESSION['nivel']) == 'atendente'*/){ ?>
                            <a href="form-adicionar-funcionario.php?idSetor=<?= $_GET['idSetor'] ?>&setor=<?= $_GET['setor'] ?>">Adicionar</a> 
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
                            <th>Celular</th>
                            <?php  if($exibirBotoes){ ?>
                                <th class="acao">Ação</th> 
                            <?php } ?> 
                        </tr> 
                    </thead>
                    
                    <tbody>
                        <?php if(!isset($listaDeRegistros) && !empty($listaDeRegistros = pegarListaFuncionarios($_GET['setor']))){
                            $_SESSION['arrayFuncionarios'] = $listaDeRegistros;
                                                    
                            foreach($listaDeRegistros as $linha){ 
                                $dadosFuncionario = $linha; ?>
                                <tr> 
                                    <td><?= $dadosFuncionario['nome'] ?></td>
                                    <td class="center"><?= $_GET['setor'] ?></td> 

                                    <?php // coloca a máscara no número do telefone para exibição
                                        if(strlen($dadosFuncionario['telefone']) == 10){
                                            $novo = substr_replace($dadosFuncionario['telefone'], '(', 0, 0);
                                            $novo = substr_replace($novo, '9', 3, 0);
                                            $novo = substr_replace($novo, ')', 3, 0);
                                        }else{
                                            $novo = substr_replace($dadosFuncionario['telefone'], '(', 0, 0);
                                            $novo = substr_replace($novo, ')', 3, 0);
                                        }  
                                        $novo = substr_replace($novo, '-', 9, 0);
                                        $novo = substr_replace($novo, ' ', 4, 0);
                                        $dadosFuncionario['telefone'] = $novo;
                                    ?>
                                    <td class="center"><?= $dadosFuncionario['telefone'] ?></td>
                                    
                                    <?php if($exibirBotoes){ ?> 
                                        <td class="alinhamento-btn">   
                                            <a class="btn-editar" title='Editar funcionário' onClick="confirmarEdicao(event, ' <?= $dadosFuncionario['nome'] ?>')" href="form-editar-funcionario.php?idFunc=<?= $dadosFuncionario['idFunc']?>&nome=<?= $dadosFuncionario['nome'] ?>&telefone=<?= $dadosFuncionario['telefone'] ?>&setor=<?= $_GET['setor'] ?>"></a> 
                                            <a class="btn-excluir" title='Excluir funcionário' onClick="confirmarExclusao(event, 'Deseja realmente excluir <?= $dadosFuncionario['nome'] ?> ?', '')" href="../controle/controle-deletar-funcionario.php?idFunc=<?= $dadosFuncionario['idFunc']?>"></a>  
                                        </td> 
                                    <?php } ?>
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