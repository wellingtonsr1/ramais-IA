<?php    
    include "../includes/cdns.php";
    require_once "../controle/validador-acesso.php";
    include_once "../controle/funcoes-de-controle.php";
    require_once "../modelo/atualizar-senha.php";
  
    //Acesso não autorizado(Usuário não autenticado)?
    if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){ header('Location: login.php?login=erro2'); }

    //primeiro acesso?
    if($_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
   
    //variável POST não definida ou vazia?
    if(!isset($_POST) || empty($_POST)){
        $erro = 'Nada foi enviado.';
    }else{
       
        //dados recuperados do formulário
        $id = $_POST['id'];
        $novaSenha = $_POST['novaSenha'];
        $senhaConfirmada = $_POST['senhaConfirmada'];
        
        if(isset($_SESSION['opcao']) && !empty($_SESSION['opcao'])){
            $opcao =  $_SESSION['opcao'];
        }

        if(verificarSenhas($novaSenha, $senhaConfirmada)){
            
            //as senhas são iguais?
            if($novaSenha == $senhaConfirmada){
                //primeiro acesso?
                $primeiroacesso = isset($_POST['primeiroacesso']) ? 'sim' : 'nao';

                //Criptografa a senha informada
                $options = ['cost' => 8];
                $novoHashSenha = password_hash($novaSenha, PASSWORD_BCRYPT, $options);
                
                if(atualizarSenha($id, $novoHashSenha, $primeiroacesso)){
                    switch ($opcao) {
                        case 'reset': //o admin resetou a senha de algum usuário?
                            $_SESSION['status'] = 'sucessoRedfSenha';
                            $verbo = 'redefinir';
                            break;
                        
                        case 'alt': //algum usuário alterou sua senha?
                            $_SESSION['status'] = 'sucessoEdtSenha';
                            $verbo = 'alterar';
                            break;
                    }
                    header('Location: ../visao/form-'.$verbo.'-senha.php');
                }
            }else{//senhas informadas são diferentes?          
                if($opcao == 'reset'){
                    $_SESSION['status'] = 'senhasDiferentes';
                    //aqui o '$id' é concatenado, mas no 'form-alterar-senha.php' porque ele usa o '$_SESSION['id']' na página
                    header('Location: ../visao/form-redefinir-senha.php?id='.$id);
                }
                if($opcao == 'alt'){
                    $_SESSION['status'] = 'senhasDiferentes';
                    header('Location: ../visao/form-alterar-senha.php');
                }
            }
        
        }else{//algo está errado? 
            $_SESSION['status'] = 'erroSenha';
             
            if($opcao == 'reset'){
                //aqui o '$id' é concatenado, mas no 'form-alterar-senha.php' porque ele usa o '$_SESSION['id']' na página
                header('Location: ../visao/form-redefinir-senha.php?id='.$id);
            }else if($opcao == 'alt'){
                header('Location: ../visao/form-alterar-senha.php');
            }
        }
    }

 
?>