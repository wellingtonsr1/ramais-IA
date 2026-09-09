<?php
    //sessão não foi iniciada?
    if(!isset($_SESSION)) { session_start(); }
    
    $_SESSION = array();

    session_destroy();
 
    //força a chamada para página 'index.php'
    header('Location: ../index.php');
?>