<?php
    include "../includes/cdns.php";
    require_once "validador-acesso.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: form-alterar-senha.php'); }

    include_once "../controle/funcoes-de-controle.php";
    include_once "../modelo/inserir-ramal.php";

    //POST não foi definida ou está vazia?
    if (!isset($_POST) || empty($_POST)) {
        $erro = 'Nada foi enviado.';
    }else{
        if(empty($_POST['setor']) || empty($_POST['ramal'])){
            $erro = 'Setor ou ramal não informado(s)';
        }else{
            //variáveis recuperadas do formulário
            $encoding = mb_internal_encoding(); 
            $setor = mb_strtoupper(trim($_POST['setor']), $encoding);
            $ramal = trim($_POST['ramal']);
            $responsavel = mb_strtoupper(trim($_POST['responsavel']), $encoding);
           
            //tudo certo com os dados?
            if(setor($setor) && ramal($ramal) && responsavel($responsavel)){
                if(adicionarRamal($setor, $ramal, $responsavel)){ 
                    $_SESSION['status'] = 'sucessoAdd';
                }else{//algo está errado? 
                    $_SESSION['status'] = 'erroAdd';
                }
            }else{//algo está errado? 
                $_SESSION['status'] = 'erroAdd';
            }
            header('Location: ../visao/form-adicionar-ramal.php'); 
        }
    }

?>

