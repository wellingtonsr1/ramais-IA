<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso.php';
cabecalhos_seguranca();

$_SESSION['opcao'] = 'alt'; // the user is changing their own password
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Alterar senha</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-alterar-senha">
                <form method="post" action="../controle/controle-atualizar-senha.php">
                    <?php if (($_SESSION['primeiroacesso'] ?? '') !== 'sim'): ?>
                        <?php if (in_array($_SESSION['nivel'] ?? '', ['admin', 'atendente'], true)): ?>
                            <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="formata-btn-home"> <a href="../controle/logoff.php">Sair</a> </div>
                    <?php endif; ?>

                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Alterar senha</span></legend>
                        <div><input type="hidden" name="id" id="id" value="<?= (int)($_SESSION['id'] ?? 0) ?>"></div>
                        <div class="inputs-alterar-senha">
                            <div>
                                <label for="novaSenha">Nova senha <span class="label-asterisco">*</span></label>
                                <span id='spanNovaSenha' class="nao-visivel">Mínimo 8 caracteres: números, letras e @$&amp;!#%</span>
                            </div>
                            <div>
                                <input class="campo-input" type="password" name="novaSenha" id="novaSenha" placeholder="Informe a senha"
                                onkeyup="verificarTextoNovaSenha()" required>
                            </div>

                            <div>
                                <label for="senhaConfirmada">Confirme a senha <span class="label-asterisco">*</span></label>
                                <span id='spanSenhaConfirmada' class="nao-visivel">Mínimo 8 caracteres: números, letras e @$&amp;!#%</span>
                            </div>
                            <div>
                                <input class="campo-input" type="password" name="senhaConfirmada" id="senhaConfirmada" placeholder="Repita a senha"
                                onkeyup="verificarTextoSenhaConfirmada()" required>
                                <button class="btn-senha" type="button" onmousedown="mostrarSenha('novaSenha', 'senhaConfirmada')" onmouseup="mostrarSenha('novaSenha', 'senhaConfirmada')"></button>
                            </div>
                        </div>
                        <div><p class="campo-obrigatorio-altera-senha"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>
                        <div class="clear"></div>

                        <div class="botoes-rodape-alterar-senha">
                            <?php echo campo_csrf(); // P-07 ?>
                            <input class="enviar-submit" type="submit" value="Alterar">
                            <input class="limpar-submit" type="reset" value="Limpar">
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
    <?php
    include "../includes/cdns.php";

    if (!empty($_SESSION['status'])) {
        switch ($_SESSION['status']) {
            case 'senhasDiferentes': ?>
                <script> erroSenha('Senhas não conferem.') </script>
                <?php break;
            case 'erroSenha': ?>
                <script> erroSenha('Há algo errado com as senhas.') </script>
                <?php break;
        }
        unset($_SESSION['status']);
    }
    ?>
</html>
