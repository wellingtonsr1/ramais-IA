<?php
    include_once "../modelo/buscar-ramal.php";
    include_once "../controle/funcoes-de-controle.php";

    //verifica se o setor informado existe; se sim, retorna para ser exibido
    /*function verificarSetor($setor){
        if(setor($setor)){
           $registroSetor = buscarSetor($setor);
            
           return $registroSetor;
        }else{//algo está errado?
            header('Location: ../visao/mensagem.php?msg=erro');
        }
    }*/

    //verifica se o setor informado existe; se sim, retorna para ser exibido
    function pegarListaSetores($setor){
        if(setor($setor)){ 
           $registroSetor = buscarSetor($setor);
           
           return $registroSetor;
        }else{//algo está errado?
            header('Location: ../visao/mensagem.php?msg=erro');
        }
    }
?>