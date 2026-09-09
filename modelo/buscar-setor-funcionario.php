<?php
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); }
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //busca uma Lista com todos os setores
    function buscarSetorFuncionario($setor){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select DISTINCT s.setor, s.idSetor, s.ramal, s.responsavel from funcionarios as f Right JOIN setores as s on (s.idSetor = f.fk_idSetor)  WHERE s.setor like :setor or f.nome like :setor';

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':setor', $setor."%");

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


    //busca uma Lista com todos os funcionarios
    function buscarFuncionarioSetor($nome){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select f.idFunc, f.nome, f.telefone, s.setor, s.idSetor from funcionarios as f INNER JOIN setores as s on s.idSetor = f.fk_idSetor WHERE s.setor like :nome or f.nome like :nome';

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':nome', $nome."%");

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