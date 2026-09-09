<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso-admin.php';
require_once __DIR__ . '/../modelo/buscar-usuario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

$_SESSION['opcao'] = 'reset'; // the admin is resetting another user's password

// P-14: no more $_GET['usuario'] (it did not exist in the links); data by id from the DATABASE
$id = requisicao_id('id');
$registro = ($id !== null) ? buscarUsuarioPorId($id) : null;
if ($registro === null) {
    redirecionar('listar-usuarios.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Redefinir senha</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-alterar-senha">
                <form method="post" action="../controle/controle-atualizar-senha.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"> <a href="listar-usuarios.php">Voltar</a> </div>
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Redefinir senha</span></legend>
                        <div>
                            <input type="hidden" name="id" id="id" value="<?= (int)$registro['id'] ?>">
                        </div>

                        <div class="inputs-alterar-senha">
                            <div>
                                <label>Redefinir a senha de: <strong><?= e((string)$registro['usuario']) ?></strong></label>
                            </div>
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
                                <button class="btn-senha" type="button" onclick="mostrarSenha('novaSenha', 'senhaConfirmada')"></button>
                            </div>
                            <div>
                                <input type="checkbox" id="primeiroacesso" name="primeiroacesso" value="sim"> Usuário deve alterar a senha.
                            </div>
                        </div>
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>
                        <div class="clear"></div>

                        <div class="botoes-rodape-redefinir-senha">
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
            case 'sucessoRedfSenha': ?>
                <script> sucessoSenha('listar-usuarios.php', 'A Senha do usuário foi alterada com sucesso!', '') </script>
                <?php break;
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
