<?php
    include "../includes/cdns.php";
    require_once "../controle/validador-acesso-admin.php"; 
    include "../controle/funcoes-de-controle.php";
    include_once "../modelo/atualizar-usuario.php";
    require_once "../modelo/contar-nivel-usuario.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //seessão do admin?
    if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'admin'){
        //variável POST não definida ou vazia?
        if (!isset($_POST) || empty($_POST)) {
            $erro = 'Nada foi enviado.';
        }else{
            //dados recuperados do formulário
            $id = $_POST['id'];
            //$usuario = $_POST['usuario'];
            $nivel = $_POST['nivel'];
            $email = $_POST['email'];

            //email não informado?
            $email = empty($email) ? "não informado" : $email;          

            //tudo certo com os dados?
            if(nivel($nivel) && email($email)){
                $totalNivelAdmin = contarNivel();
                if($totalNivelAdmin != 1 || $nivel == 'admin'){
                    if(atualizarUsuario($id, $nivel, $email)){ 
                        $_SESSION['status'] = 'sucessoEditar';
                    }
                }else{
                    $_SESSION['status'] = $totalNivelAdmin == 1 ? 'erroEditarAdmin' : 'erroEditar';
                }
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroEditar';
            } 
           header('Location: ../visao/listar-usuarios.php');
        } 
    }
?>