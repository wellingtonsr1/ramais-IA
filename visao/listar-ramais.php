<!DOCTYPE html>

<?php 
    include "../controle/controle-listar-ramais.php";
    
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
        <?php include "favicon.php" ?>
        <title>Listar ramais</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script> 
        
    </head>

    <body>
        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>

            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar">  
                    <form action="filtrar-ramal.php" method="post">      
                        <input class="campo-filtrar" name="setor" type="text" name="setor" id="setor" placeholder="Informe o setor ou nome" autocomplete="off" autocorrect="off" autofocus required>
                        <button class="btn-filtrar" id="btnBusca">Filtrar</button> 
                    </form>
                </div> 
                <div class="lado-direito-filtrar">
                    <a href="../modelo/exportar-em-pdf.php" >Salvar em PDF</a>
                   
                    <?php //o botão 'sair' só aparecerá se o usário for o admin ou atendente 
                        if(isset($_SESSION['nivel']) == 'admin' || isset($_SESSION['nivel']) == 'atendente'){ ?>
                            <a href="form-adicionar-ramal.php">Adicionar</a>
                            <a href="../index.php">Home</a>  
                            <a href="../controle/logoff.php">Sair</a>
                    <?php }else{ ?>
                        <a href="login.php">Login</a>
                    <?php } ?>
                </div>    
            </div>

            <div id="area-tabela">  
                <table class="table-container"> 
                    <thead>
                        <tr>  
                            <th>Setor</th> 
                            <th class="ramal">Ramal</th>
                            <th class="responsavel">Responsável</th>
                            <th id="acao">Ação</th> 
                        </tr> 
                    </thead>
                    
                    <tbody>
                        <?php if(!isset($listaDeRegistros) && !empty($listaDeRegistros = pegarListaSetores())){                           
                            foreach($listaDeRegistros as $linha){
                                $dadosRamal = $linha;?>
                                <tr> 
                                    <td><?= $dadosRamal['setor'] ?></td>

                                    <?php //$dadosRamal['ramal'] = $dadosRamal['ramal'] == 0 ? '' : $dadosRamal['ramal'];?>
                                    <td class="ramal"><?= $dadosRamal['ramal'] = $dadosRamal['ramal'] == 0 ? '' : $dadosRamal['ramal']; //$dadosRamal['ramal'] ?></td>
                                    
                                    <td class="responsavel"><?= $dadosRamal['responsavel'] ?></td> 
                                   
                                    <td class="alinhamento-btn"> 
                                        <a class="btn-funcionarios" title='Exibir Funcionários' href="../visao/listar-funcionarios-com-setor.php?idSetor=<?= $dadosRamal['idSetor'] ?>&setor=<?= $dadosRamal['setor'] ?>"></a> 
                                        <?php if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){ ?>  
                                            <a class="btn-editar" onClick="confirmarEdicao(event,  ' <?= $dadosRamal['setor'] ?>')" title='Alterar ramal' href="form-editar-ramal.php?idSetor=<?= $dadosRamal['idSetor'] ?>&setor=<?= $dadosRamal['setor'] ?>&ramal=<?= $dadosRamal['ramal'] ?>&responsavel=<?= $dadosRamal['responsavel'] ?>"></a> 
                                            <?php  if($_SESSION['nivel'] == 'admin'){ ?> 
                                                <a class="btn-excluir" onClick="confirmarExclusao(event, 'Deseja realmente excluir <?= $dadosRamal['setor'] ?> ?', '')" title='Excluir ramal' href="../controle/controle-deletar-ramal.php?idSetor=<?= $dadosRamal['idSetor'] ?>&setor=<?= $dadosRamal['setor'] ?>"></a> 
                                            <?php } ?>
                                        <?php } ?>
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
    <?php 
        if(isset($_SESSION['status']) && !empty($_SESSION['status'])){
            include "../includes/cdns.php"; 

            switch ($_SESSION['status']) {
                case 'sucessoDel': ?>
                    <script> sucessoDel('listar-ramais.php') </script>   
                    <?php  break;
                case 'erroDel': ?>
                    <script> erroDel('listar-ramais.php', 'Erro ao excluir o registro!') </script> 
                    <?php break;
                case 'sucessoEditar': ?>
                    <script> sucessoEditar('listar-ramais.php') </script>
                    <?php break;
                case 'erroEditar': ?>
                    <script> erroEditar('listar-ramais.php', 'Não foi possível alterar os dados!') </script>
                    <?php break;
            }
            unset($_SESSION['status']);
        }   
    ?>
</html>