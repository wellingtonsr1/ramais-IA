<?php
    require_once "../controle/validador-acesso-admin.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function deletarUsuario($id){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "delete from usuarios where id=:id";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':id', $id);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao deletar os dados do banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        }        
    }
?>