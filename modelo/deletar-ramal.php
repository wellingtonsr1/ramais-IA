<?php
    require_once "../controle/validador-acesso.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function deletarRamal($idSetor){
        //script de conexão ao banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "delete from setores where idSetor=:idSetor";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':idSetor', $idSetor);
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao deletar dados do banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        } 
    }
?>