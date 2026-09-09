<?php
    require_once "../controle/validador-acesso-admin.php";
    include_once "../modelo/buscar-usuario.php";
    include_once "../controle/funcoes-de-controle.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }
    
    //verifica se o usuário informado existe; se sim, retorna para ser exibido
    function verificarUsuario($usuario){
        if(usuario($usuario)){
            $registroUsuario = buscarUsuario($usuario);

            return $registroUsuario;
        }else{//algo está errado?
            header('Location: ../visao/mensagem.php?msg=erro');
        }
    }
?>