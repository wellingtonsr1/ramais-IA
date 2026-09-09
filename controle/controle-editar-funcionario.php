<?php
    require_once "../controle/validador-acesso-admin.php"; 
    include_once "../controle/funcoes-de-controle.php";
    include_once "../modelo/atualizar-funcionario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //seessão do admin?
    if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'admin'){
        //variável POST não definida ou vazia?
        if (!isset($_POST) || empty($_POST)) {
            $erro = 'Nada foi enviado.';
        }else{

            //dados recuperados do formulário
            $encoding = mb_internal_encoding(); 
            $idFunc = $_POST['idFunc'];
            $nome = mb_strtoupper(trim($_POST['nome']), $encoding);
            
            $telefone = str_replace('(', '', $_POST['telefone']);
            $telefone = str_replace(')', '', $telefone);
            $telefone = str_replace('-', '', $telefone);
            $telefone = str_replace(' ', '', $telefone);

            $telefone = empty($telefone) ? '00000000000' : $telefone;

            $idSetor = $_POST['idSetor'];

            //tudo certo com os dados?
            if(nome($nome) && telefone($telefone) && (strlen($telefone) == 10 || strlen($telefone) == 11)){
                if(atualizarFuncionario($idFunc, $nome, $telefone, $idSetor)){ 
                     $_SESSION['status'] = 'sucessoEditar';
                }
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroEditar';
            }
            header('Location: ../visao/listar-funcionarios.php');
        } 
    }
?>