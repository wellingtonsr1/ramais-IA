<?php  
   if(!isset($_SESSION)) { session_start(); }

   $dsn = 'mysql:host=sql113.byetcluster.com;dbname=epiz_28538005_listagemDeRamais;charset=utf8';
   $user = 'epiz_28538005';
   $password = '2C8uvFBSL1xDG'; 

   //Tenta conectar ao banco
   try {
      $conexao = new PDO($dsn, $user, $password); 
   } catch (PDOException $e) {
      echo 'Erro: ' . $e->getCode() . ' Mensagem: ' . $e->getMessage();
   }
?>