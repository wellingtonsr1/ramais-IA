<?php
    require_once "../controle/validador-acesso-admin.php";
   
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function adicionarUsuario($usuario, $hashSenha, $nivel, $email, $primeiroacesso){
        //script de conexão com banco
        require "conecta-banco.php";
    
        try {
            //Query montada
            $query = "insert into usuarios(usuario, hashSenha, nivel, email, primeiroacesso) values (:usuario, :hashSenha, :nivel, :email, :primeiroacesso)";
       
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':hashSenha', $hashSenha);
            $stmt->bindValue(':nivel', $nivel);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':primeiroacesso', $primeiroacesso);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao inserir os dados na banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        }      
    }
?>