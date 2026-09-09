<?php
    require_once "controle/validador-acesso.php";

    //qual o nível de acesso do usuário?
    switch ($_SESSION['nivel']) {
        case 'admin':
            header('Location: visao/admin.php'); 
            break;
        case 'atendente':
            header('Location: visao/atendente.php'); 
            break;
        default:
            header('Location: visao/listar-ramais.php'); 
        break;
    }
?>