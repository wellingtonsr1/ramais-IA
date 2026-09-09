<?php
    require_once "../controle/validador-acesso.php";

    function atualizarSenha($id, $novoHash, $primeiroacesso){
        //script de conexão com banco
        require "conecta-banco.php";
       
        try {
            //Query montada
            $query = "update usuarios SET hashSenha=:novoHash, primeiroacesso=:primeiroacesso WHERE id=:id";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':novoHash', $novoHash);
            $stmt->bindValue(':primeiroacesso', $primeiroacesso);

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
