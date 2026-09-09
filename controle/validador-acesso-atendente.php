<?php
    if(!isset($_SESSION)) { session_start(); } 

    //não é autenticado?
    if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM' || $_SESSION['nivel'] != 'atendente'){
        header('Location: ../visao/login.php?login=erro2');
    }
?>