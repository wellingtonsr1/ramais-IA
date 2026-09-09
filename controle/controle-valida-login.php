<?php
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); }
   
    include_once "../modelo/buscar-login.php";

    $usuario_autenticado = false;
    $nivel_usuario = null;

    $usuario = $_POST['usuario'];

    $dadosUsuario = buscarUsuario($usuario);
  
    //Verifica se a senha informada é compatível com o hash salvo no banco?
    $senhaVerificada = password_verify($_POST['senha'], $dadosUsuario['hashSenha']);

    //usuário informado é igual ao retornado do banco?
    if((isset($dadosUsuario['usuario']) == $_POST['usuario']) && $senhaVerificada){ 
        $idUsuario = $dadosUsuario['id'];
        $nomeUsuario = $dadosUsuario['usuario'];
        $nivelUsuario = $dadosUsuario['nivel'];
        $primeiroacesso = $dadosUsuario['primeiroacesso'];
        $usuarioAutenticado = true;
    }
    
    //Usuário autenticado?
    if($usuarioAutenticado){
        //Criação das variáveis de sessão
        $_SESSION['autenticado'] = 'SIM';
        $_SESSION['id'] = $idUsuario;
        $_SESSION['usuario'] = $nomeUsuario; 
        $_SESSION['nivel'] = $nivelUsuario;
        $_SESSION['primeiroacesso'] = $primeiroacesso;
        //$_SESSION['hashSenha'] = $dadosUsuario['hashSenha'];
        
        //primeiro acesso?
        if($primeiroacesso == 'sim'){  
            header('Location: ../visao/form-alterar-senha.php');
        }else{ 
            //admin ou atendente?
            if($nivelUsuario == 'admin'){
                header('Location: ../visao/admin.php');
            }else{
                header('Location: ../visao/atendente.php');   
            }     
        }  
    }else{
        //usuário não foi autenticado?
        $_SESSION['autenticado'] = 'NAO';
        header('Location: ../visao/login.php?login=erro');
    }
   
?>