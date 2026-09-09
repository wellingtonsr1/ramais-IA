<?php 
    //sessão não foi iniciada?
    if(!isset($_SESSION)) {session_start();} 

    //variável de sessão foi definida e está vazia?
    if(!isset($_SESSION['usuario']) && empty($_SESSION['usuario'])){$_SESSION['usuario'] = 'convidado';}
?>

<div id="topo">
    <!-- inclui o script funcoes.js em todas as páginas-->
    <script src="../js/funcoes.js"></script>
    
    <div id="logo">
        <img width="190"  src="../imagem/ipmjp.png" alt="logo-ipmjp">
    </div>

    <div id="texto-logo">
        <h1>Listagem de Ramais </h1>
    </div>
</div>