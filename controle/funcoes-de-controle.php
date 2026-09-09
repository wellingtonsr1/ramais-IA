<?php
    function setor($setor){
        //if(preg_match('/^[A-Za-zà-úÀ-ÚçÇ]+[_\/\.-]?(\s[A-Za-z]{2,3})?(\s?[A-Za-zà-úÀ-ÚçÇ]+)[_\/\.-]?(\s?[A-Za-zà-úÀ-ÚçÇ]+)?[\s\.]?([0-9]+)?$/', $setor)){
        if(preg_match('/^[A-Za-zà-úÀ-ÚçÇ]+([_\/\.-]?(\s[A-Za-z]{2,3})?(\s?[A-Za-zà-úÀ-ÚçÇ]+)[_\/\.-]?(\s?[A-Za-zà-úÀ-ÚçÇ]+)?[\s\.]?([0-9]+)?)?$/', $setor)){
            return TRUE;
        }
    }

    function ramal($ramal){
        if(preg_match('/^[0-9]{3,8}$/', $ramal)){
            return TRUE;
        }
    }

    function responsavel($responsavel){
        if(preg_match('/^[A-Za-zà-úÀ-ÚçÇ]+[\s]?([A-Za-z]+)?[-\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/', $responsavel)){
            return TRUE;
        } 
    }

    function usuario($usuario){
        if(preg_match('/^[a-z]+[.]?([a-z]+)?$/', $usuario)){
            return TRUE;
        } 
    }

    function senha($senha){
        if(preg_match('/^[A-Za-z0-9@$&!#%]{1,}$/', $senha)){
            return TRUE;
        }
    }

    function nivel($nivel){
        return (is_string($nivel)) ? TRUE : FALSE;
    }

    function primeiroacesso($primeiroacesso){
        if(preg_match('/^[a-z]{3}$/', $primeiroacesso)){
            return TRUE;
        }
    }

    function email($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL) || $email == 'não informado'){
            return TRUE;
        }
    }

    function verificarSenhas($novaSenha, $senhaConfirmada){
        //^[A-Za-zà-úÀ-ÚçÇ]+([\s][A-Za-z]{2,3})?[\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/
        if (preg_match('/^[A-Za-z0-9@$&!#%]{1,}$/', $novaSenha) && preg_match('/^[A-Za-z0-9@$&!#%]{1,}$/', $senhaConfirmada)){
            return TRUE; 
        }
    }

    // nome do funcionário
    function nome($nome){
        //if(preg_match('/^[A-Za-zà-úÀ-ÚçÇ]+[\s]?([A-Za-z]{2,3})?[\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/', $nome)){
        if(preg_match('/^[A-Za-zà-úÀ-ÚçÇ]+([\s][A-Za-z]{2,3})?[\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/', $nome)){
            return TRUE;
        } 
    }

    // telefone do funcionário
    function telefone($telefone){
        if(preg_match('/^[0-9]+$/', $telefone)){
            return TRUE;
        }   
    }

    /*function formataTelefone($telefone){
        if(strlen($telefone) == 10){
            $novo = substr_replace($telefone, '(', 0, 0);
            $novo = substr_replace($novo, '9', 3, 0);
            $novo = substr_replace($novo, ')', 3, 0);
            $novo = substr_replace($novo, '-', 9, 0);
        }else{
            $novo = substr_replace($dadosFuncionario['telefone'], '(', 0, 0);
            $novo = substr_replace($novo, ')', 3, 0);
            $novo = substr_replace($novo, '-', 9, 0);
        }
        return $novo; 
    }*/
?>
     
     