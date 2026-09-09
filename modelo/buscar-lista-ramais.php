<?php
    //busca uma Lista com todos os setores
    function buscarSetores(){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select * from setores ORDER by setor';
            
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);

            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar a listar de ramais.');
            }else{
                $listaDeRegistros = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
                return $listaDeRegistros;
            }
        } catch (Exception $e) {
            echo $e;
        }  
    }
?>