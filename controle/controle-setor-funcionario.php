<?php
    include_once "../modelo/buscar-setor-funcionario.php";
    
    function pegarSetorFuncionario($idSetor){
        $funcionarios = buscarSetorFuncionario($idSetor);
        
        return $funcionarios;
    }
?>