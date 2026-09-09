<?php
    include "../includes/cdns.php";
    require_once "validador-acesso-admin.php";
    include_once "funcoes-de-controle.php";
    include_once "../modelo/adicionar-funcionario.php";
    //include_once "../modelo/existe-usuario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }

    //POST não foi definida ou está vazia?
    if (!isset($_POST) || empty($_POST)) {
        $erro = 'Nada foi enviado.';
    }else{    
       
        $encoding = mb_internal_encoding(); 
        $nome = mb_strtoupper(trim($_POST['nome']), $encoding);
        
        // retira os '()' e o '-' do telefone
        $telefone = str_replace('(', '', $_POST['telefone']);
        $telefone = str_replace(')', '', $telefone);
        $telefone = str_replace('-', '', $telefone);
        $telefone = str_replace(' ', '', $telefone);

        $telefone = empty($telefone) ? '00000000000' : $telefone;

        $idSetor = $_POST['idSetor'];

        //tudo certo com os dados?
        if(nome($nome) && telefone($telefone) && (strlen($telefone) == 10 || strlen($telefone) == 11)){
            if(adicionarFuncionario($nome, $telefone, $idSetor)){ 
                $_SESSION['status'] = 'sucessoAdd';
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroAdd';
            }
        }else{//algo está errado? 
            $_SESSION['status'] = 'erroAdd';
        }
        header('Location: ../visao/form-adicionar-funcionario.php');
    }
?>