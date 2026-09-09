<?php
    //require_once "../controle/validador-acesso-admin.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //busca uma Lista com todos os usuários
    function buscarFuncionarios(){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select f.idFunc, f.nome, f.telefone, s.setor from funcionarios as f INNER JOIN setores as s on s.idSetor = f.fk_idSetor order by f.nome';
           
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);

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