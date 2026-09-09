<?php
    require_once "../controle/validador-acesso-admin.php"; 

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    function atualizarUsuario($id, $nivel, $email){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "update usuarios SET nivel=:nivel, email=:email WHERE id=:id";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':nivel', $nivel);
            $stmt->bindValue(':email', $email);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao atualizar os dados na banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        }  
    }
?>