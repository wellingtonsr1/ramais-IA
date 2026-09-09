<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === '') {
    $_SESSION['usuario'] = 'convidado';
}
?>

<div id="topo">
    <script src="../js/funcoes.js"></script>

    <div id="logo">
        <img width="190" src="../imagem/ipmjp.png" alt="Logotipo do IPMJP">
    </div>

    <div id="texto-logo">
        <h1>Listagem de Ramais </h1>
    </div>
</div>
