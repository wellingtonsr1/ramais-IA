<?php
    require_once "../controle/validador-acesso-admin.php"; 
    
    if(!isset($_SESSION)) {session_start();}

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    function contarNivel(){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "select nivel from usuarios where nivel=:nivel";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':nivel', 'admin');
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar nível');
            }else{
                return $stmt->rowCount();
            }
        } catch (Exception $e) {
            echo $e;
        } 
    }
?>