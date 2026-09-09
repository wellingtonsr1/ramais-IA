<?php
    require_once "../controle/validador-acesso-admin.php";
   
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function adicionarFuncionario($nome, $telefone, $idSetor){
        //script de conexão com banco
        require "conecta-banco.php";
    
        try {
            //Query montada
            $query = "insert into funcionarios(nome, telefone, fk_idSetor) values (:nome, :telefone, :idSetor)";
       
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':telefone', $telefone);
            //$stmt->bindValue(':email', $email);
            $stmt->bindValue(':idSetor', $idSetor);

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