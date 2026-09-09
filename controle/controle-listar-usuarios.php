<?php
    require_once "../controle/validador-acesso-admin.php";
    include_once "../modelo/buscar-lista-usuarios.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function pegarListaUsuarios(){
        $usuarios = buscarUsuarios();
      
        return $usuarios;
    }
?>