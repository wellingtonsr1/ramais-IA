<?php
    require_once "../controle/validador-acesso.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }

    function buscarUsuario($usuario){
        //script de conexão com banco
        require "conecta-banco.php";
    
        try {
            //Query montada
            $query = "select * from usuarios where usuario = :usuario";
     
            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':usuario', $usuario);
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao deletar dados do banco.');
            }else{
                $dadosUsuario = $stmt->fetch();
            
                return $dadosUsuario;
            }
        } catch (Exception $e) {
            echo $e;
        } 
        
    }
?>