<?php
    include_once "../modelo/buscar-lista-ramais.php";

    function pegarListaSetores(){
        $setores = buscarSetores();
       
        return $setores;
    }
?>