<?php
    include "../includes/cdns.php";
    require_once "validador-acesso-admin.php";
    require_once "../modelo/deletar-usuario.php";
    require_once "../modelo/contar-nivel-usuario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //Variável $_GET definida ou vazia?
    if (!isset($_GET) || empty($_GET)) {
        $erro = 'Nada foi enviado.';
    }else{
        if(!empty($_GET['id']) && !empty($_GET['nivel'])){
            $totalNivelAdmin = contarNivel();
            if($_GET['nivel'] == 'admin' && $totalNivelAdmin != 1 || $_GET['nivel'] == 'atendente'){
                if(deletarUsuario($_GET['id'])){ 
                    $_SESSION['status'] = 'sucessoDel';
                }
            }else{
                $_SESSION['status'] = $totalNivelAdmin == 1 ? 'erroDelAdmin' : 'erroDel';
            }
        }else{//algo está errado? 
             $_SESSION['status'] = 'erroDel';
        }
        header('Location: ../visao/listar-usuarios.php');
    } 
?>