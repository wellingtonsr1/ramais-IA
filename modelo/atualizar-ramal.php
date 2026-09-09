<?php
    require_once "../controle/validador-acesso.php"; 
 
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    function atualizarRamal($idSetor, $setor, $ramal, $responsavel){
        //script de conexão com banco
        require "conecta-banco.php";
        
        try {
            //Query montada para atualizar o setor
            $query = "update setores SET setor=:setor, ramal=:ramal, responsavel=:responsavel WHERE idSetor=:idSetor";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':idSetor', $idSetor);
            $stmt->bindValue(':setor', $setor);
            $stmt->bindValue(':ramal', $ramal);
            $stmt->bindValue(':responsavel', $responsavel);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao atualizar os dados no banco.');
            }else{
                return TRUE;
            }
        } catch (Exception $e) {
            echo $e;
        }    
    }
?>