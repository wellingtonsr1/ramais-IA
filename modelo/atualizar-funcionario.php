<?php
    require_once "../controle/validador-acesso-admin.php"; 

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    function atualizarFuncionario($idFunc, $nome, $telefone, $idSetor){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "update funcionarios SET nome=:nome, telefone=:telefone, fk_idSetor=:idSetor  WHERE idFunc=:idFunc";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);

            $stmt->bindValue(':idFunc', $idFunc);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':idSetor', $idSetor);

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