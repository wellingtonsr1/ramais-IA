<?php
    include "../includes/cdns.php";
    require_once "validador-acesso-admin.php";
    require_once "../modelo/deletar-funcionario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //Variável $_GET definida ou vazia?
    if (!isset($_GET) || empty($_GET)) {
        $erro = 'Nada foi enviado.';
    }else{
        if(!empty($_GET['idFunc'])){
            if(deletarFuncionario($_GET['idFunc'])){ 
                $_SESSION['status'] = 'sucessoDel';
             }else{ 
                $_SESSION['status'] = 'erroDel';
            }
        }else{//algo está errado? 
            $_SESSION['status'] = 'erroDel';
        }
        header('Location: ../visao/listar-funcionarios.php');
    } 
?>