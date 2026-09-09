<!DOCTYPE html>

<?php  
    require "../controle/validador-acesso-admin.php"; 
    require "../controle/controle-listar-usuarios.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){
        header('Location: form-alterar-senha.php');
    }  
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
       <!--<link rel="stylesheet" type="text/css" href="css/normalize.css">-->
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listar usuários</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    </head>

    <body>

        <div id="principal">
            <!-- inclui o arquivo 'topo.php' nesta página -->
            <?php include_once "topo.php" ?>
            
            <div id="area-filtrar">
                <div class="lado-esquerdo-filtrar"> 
                    <form action="filtrar-usuario.php" method="post">        
                        <input class="campo-filtrar" type="text" name="usuario" id="usuario" 
                        placeholder="Informe o usuário" autocomplete="off" autocorrect="off" autofocus required>
                        <button class="btn-filtrar" id="btnBusca">Filtrar</button> 
                    </form>
                </div> 
                <div class="lado-direito-filtrar">
                    <div class="formata-btn-home"><a href="../controle/logoff.php">Sair</a> </div> 
                    <div class="formata-btn-home"><a href="../index.php">Home</a></div>
                    <div class="formata-btn-home"><a href="form-adicionar-usuario.php">Adicionar</a></div>
                </div>    
            </div>
            
            <div id="area-tabela">
                <table class="table-container">
                    <thead>
                        <tr> 
                            <th>Usuário</th>
                            <th>Nível</th>
                            <th class="email">e-mail</th>
                            <th>Ação</th> 
                        </tr> 
                    </thead>
                    <tbody>
                        <?php if(!isset($listaDeRegistros) && !empty($listaDeRegistros = pegarListaUsuarios())){
                            //variavel de sessão com a lista de usuários para ser usada em 'filtrar-usuario.php'
                            $_SESSION['arrayUsuarios'] = $listaDeRegistros;
                            
                            foreach($listaDeRegistros as $linha){ 
                                $dadosUsuario = $linha;?>
                                <tr> 
                                    <td><?= $dadosUsuario['usuario'] ?></td>
                                    <td class="center"><?= $dadosUsuario['nivel'] ?></td>
                                    <td class="email"><?= $dadosUsuario['email'] ?></td> 
                                    <td class="alinhamento-btn"> 
                                        <a class="btn-editar" title='Editar usuário' onClick="confirmarEdicao(event, '<?= $dadosUsuario['usuario'] ?>')" href="form-editar-usuario.php?id=<?= $dadosUsuario['id']?>&usuario=<?= $dadosUsuario['usuario'] ?>&nivel=<?= $dadosUsuario['nivel'] ?>&email=<?= $dadosUsuario['email'] ?>"></a> 
                                        <a class="btn-excluir" title='Excluir usuário' onClick="confirmarExclusao(event, 'Deseja realmente excluir <?= $dadosUsuario['usuario'] ?> ?',  'Lembre-se: É preciso ao menos um administrador')" href="../controle/controle-deletar-usuario.php?id=<?= $dadosUsuario['id']?>&nivel=<?= $dadosUsuario['nivel'] ?>"></a>
                                        <a class="btn-alterar-senha" title='Redefinir senha' href="form-redefinir-senha.php?id=<?= $dadosUsuario['id']?>"></a> 
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
                    <script> sucessoDel('listar-usuarios.php') </script>   
                    <?php  break;
                case 'erroDel': ?>
                    <script> erroDel('listar-usuarios.php', 'Erro ao excluir o registro!') </script> 
                    <?php break;
                case 'erroDelAdmin': ?>
                    <script> erroDel('listar-usuarios.php', 'Erro: Deve haver ao menos um usuário administrador.') </script> 
                    <?php break;
                case 'sucessoEditar': ?>
                    <script> sucessoEditar('listar-usuarios.php') </script>
                    <?php break;
                case 'erroEditar': ?>
                    <script> erroEditar('listar-usuarios.php', 'Não foi possível alterar os dados!') </script>
                    <?php break;
                case 'erroEditarAdmin': ?>
                    <script> erroEditar('listar-usuarios.php', 'Erro: Deve haver ao menos um usuário administrador.') </script>
                    <?php break;
                case 'sucessoRedfSenha': ?>
                    <script> //sucessoRedefinirSenha('../index.php') </script>
                    <?php break;
            }
            unset($_SESSION['status']);
        }   
    ?>
</html>