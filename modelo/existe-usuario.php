<?php
    require_once "../controle/validador-acesso-admin.php"; 
    
    if(!isset($_SESSION)) {session_start();}

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    function existeUsuario($usuario){
        //script de conexão com banco
        require "conecta-banco.php";

        try {
            //Query montada
            $query = "select * from usuarios where usuario=:usuario";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':usuario', $usuario);
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar usuário');
            }else{
                return $stmt->rowCount();
            }
        } catch (Exception $e) {
            echo $e;
        } 
    }
?>