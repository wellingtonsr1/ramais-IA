<?php
    require_once "validador-acesso.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function adicionarRamal($setor, $ramal, $responsavel){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "insert into setores(setor, ramal, responsavel) values (:setor, :ramal, :responsavel)";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
         
            $stmt->bindValue(':setor', $setor);
            $stmt->bindValue(':ramal', $ramal);
            $stmt->bindValue(':responsavel', $responsavel);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao inserir os dados no banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        } 
    }      
?>