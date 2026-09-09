<?php
    require_once "validador-acesso.php";
    require_once "../modelo/deletar-ramal.php";
    require "../modelo/buscar-lista-funcionarios-por-setor.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //Variável $_GET definida ou vazia?
    if (!isset($_GET) || empty($_GET)) {
        $erro = 'Nada foi enviado.';
    }else{
        if(!empty($_GET['idSetor']) && !empty($_GET['setor'])){
            $registro = buscarSetorFuncionarios($_GET['setor']);
            if(empty($registro)){
                if(deletarRamal($_GET['idSetor'])){ 
                    $_SESSION['status'] = 'sucessoDel';
                }
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroDel';
            }
        }else{//algo está errado? 
            $_SESSION['status'] = 'erroDel';
        }
        header('Location: ../visao/listar-ramais.php');
    }

?>