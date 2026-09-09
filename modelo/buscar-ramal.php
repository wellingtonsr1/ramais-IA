<?php
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); }
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    //Busca por um setor específico
    function buscarSetor($setor){
        
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select distinct s.setor, s.idSetor,  s.ramal, s.responsavel from funcionarios as f Right JOIN setores as s on s.idSetor = f.fk_idSetor WHERE s.setor like :setor';
            
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':setor', $setor."%");
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar o setor.');
            }else{
                //retorna o registro
                $registro = $stmt->fetchAll(PDO::FETCH_ASSOC); 

                return $registro;
            }  
        } catch (Exception $e) {
            echo $e;
        } 
    }
?>