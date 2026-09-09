<?php
    require_once "../controle/validador-acesso-admin.php";
    
    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //busca uma Lista com todos os usuários
    function buscarUsuarios(){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = 'select * from usuarios';

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar a lista de usuários');
            }else{
                $listaDeRegistros = $stmt->fetchAll();
        
                return $listaDeRegistros;
            }    
        } catch (Exception $e) {
            echo $e;
        }  
    }
?>