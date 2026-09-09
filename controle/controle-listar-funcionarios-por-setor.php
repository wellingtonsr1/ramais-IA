<?php
    //require_once "../controle/validador-acesso-admin.php";
    include_once "../modelo/buscar-lista-funcionarios-por-setor.php";

    //primeiro acesso?
    //if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function pegarListaFuncionarios($setor){
        //$funcionarios = buscarFuncionarios($setor);
        $funcionarios = buscarSetorFuncionarios($setor);
        
        return $funcionarios;
    }
?>