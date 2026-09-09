<?php
    //require_once "../controle/validador-acesso-admin.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //busca uma Lista com todos os usuários
    function buscarFuncionarios($setor){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            //$query = 'select * from funcionarios';
            $query = 'select f.idFunc, f.nome, f.telefone, s.idSetor, s.setor, s.ramal, s.responsavel from funcionarios as f INNER JOIN setores as s on s.idSetor = f.fk_idSetor WHERE s.setor like :setor or f.nome like :setor ORDER by f.nome';
           
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':setor', $setor."%");

            return executaQuery($stmt);

        } catch (Exception $e) {
            echo $e;
        }  
    }

    //busca uma Lista com todos os usuários
    function buscarSetorFuncionarios($setor){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            //$query = 'select * from funcionarios';
            $query = 'select f.idFunc, f.nome, f.telefone, s.idSetor, s.setor from funcionarios as f INNER JOIN setores as s on s.idSetor = f.fk_idSetor WHERE s.setor like :setor or f.nome like :setor ORDER by f.nome';
           
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':setor', $setor);

            return executaQuery($stmt);
            
        } catch (Exception $e) {
            echo $e;
        }  
    }

    function executaQuery($stmt){
        try {
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar a lista de funcionários');
            }else{
                $listaDeRegistros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                return $listaDeRegistros;
            }    
        } catch (Exception $e) {
            echo $e;
        }  
    }
?>