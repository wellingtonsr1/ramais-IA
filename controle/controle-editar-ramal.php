<?php
    include "../includes/cdns.php";
    require_once "../controle/validador-acesso.php"; 
    include_once "../controle/funcoes-de-controle.php";
    include_once "../modelo/atualizar-ramal.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    //usuário admin ou atendente?
    if(isset($_SESSION['nivel']) && ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'atendente')){
        //Variável $_POST definida ou vazia?
        if (!isset($_POST) || empty($_POST)) {
            $erro = 'Nada foi enviado.';
        }else{
            
            $encoding = mb_internal_encoding(); 
            $idSetor = $_POST['idSetor'];
            $setor = mb_strtoupper(trim($_POST['setor']), $encoding);
            $ramal = $_POST['ramal'];
                       
            $responsavel = empty($_POST['responsavel']) ? 'NÃO INFORMADO' : $responsavel = mb_strtoupper(trim($_POST['responsavel']), $encoding);  //converte para minúsculo

            //if(verificarDadosRamal($setor, $ramal, $email)){
            if(setor($setor) && ramal($ramal) && responsavel($responsavel)){
                if(atualizarRamal($idSetor, $setor, $ramal, $responsavel)){ 
                    $_SESSION['status'] = 'sucessoEditar';
                }
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroEditar';
            }
            header('Location: ../visao/listar-ramais.php');
        }
    }else{
        //não tem autenticação?
        header('Location: ../visao/login.php?login=erro2');  
    }
?>