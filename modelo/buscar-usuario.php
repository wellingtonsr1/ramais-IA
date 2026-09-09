<?php
    require_once "../controle/validador-acesso-admin.php";

    //primeiro acesso?
    if(isset($_SESSION['primeiroacesso']) && $_SESSION['primeiroacesso'] == 'sim'){ header('Location: ../visao/form-alterar-senha.php'); }
    
    //Busca por um usuário específico
    function buscarUsuario($usuario){
        //script de conexão com banco
        require "conecta-banco.php";

        $usuario = "$usuario%";

        try {
            //Query montada
            //$query = "select * from usuarios where usuario=:usuario";
            $query = "SELECT * FROM `usuarios` WHERE `usuario` like :usuario";

            //preparação dos valores recebidos para evitar SqlInjection
            $stmt = $conexao->prepare($query);
            
            //$stmt->bindValue(':usuario', $usuario);
            $stmt->bindParam(':usuario', $usuario);
            
            //problema na execução da query?
            if(!$stmt->execute()){
                throw new Exception('Erro ao buscar usuário');
            }else{
                //retorna um objeto
                $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $registro;
            }
        } catch (Exception $e) {
            echo $e;
        } 
    }
?>