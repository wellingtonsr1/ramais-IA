<?php
    include "../includes/cdns.php";
    require_once "validador-acesso-admin.php";
    include_once "funcoes-de-controle.php";
    include_once "../modelo/inserir-usuario.php";
    include_once "../modelo/existe-usuario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }

    //POST não foi definida ou está vazia?
    if (!isset($_POST) || empty($_POST)) {
        $erro = 'Nada foi enviado.';
    }else{    
        //converte para minúsculo (menos a senha)
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = strtolower($_POST['email']);
        $nivel = strtolower($_POST['nivel']);

        //Primeiro acesso?
        $primeiroacesso = $_POST['primeiroacesso'] ? 'sim' : 'nao';

        //email não informado?
        $email = empty($email) ? "não informado" : $email;

        //tudo certo com os dados?
        if(usuario($usuario) && senha($senha) && nivel($nivel) && email($email) && primeiroacesso($primeiroacesso)){
            //Criptografa a senha
            $options = ['cost' => 8];
            $hashSenha = password_hash($senha, PASSWORD_BCRYPT, $options);
            if(existeUsuario($usuario) == 0){
                if(adicionarUsuario($usuario, $hashSenha, $nivel, $email, $primeiroacesso)){  
                    $_SESSION['status'] = 'sucessoAdd';
                }else{//algo está errado? 
                    $_SESSION['status'] = 'erroAdd';
                }
            }else{//algo está errado?
                $_SESSION['status'] = 'erroAddExiste';
            } 
        }else{//algo está errado? ?>
            <script> erroAdd('usuario') </script>
        <?php }
        header('Location: ../visao/form-adicionar-usuario.php');
    }
?>