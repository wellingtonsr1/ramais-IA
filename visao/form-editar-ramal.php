<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../controle/validador-acesso.php';
require_once __DIR__ . '/../controle/controle-listar-ramais.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-04: data now comes from the DATABASE by id - never from the URL
$idSetor = requisicao_id('idSetor');
$registro = null;
if ($idSetor !== null) {
    foreach (buscarSetores() as $linha) {
        if ((int)$linha['idSetor'] === $idSetor) {
            $registro = $linha;
            break;
        }
    }
}
if ($registro === null) {
    redirecionar('listar-ramais.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Editar ramal</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php"; ?>

            <div id="formulario-editar-ramal">
                <form method="post" action="../controle/controle-editar-ramal.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"> <a href="listar-ramais.php">Voltar</a> </div>
                    <fieldset>
                        <legend><span class="formata-font">Editar ramal</span></legend>
                        <div><input type="hidden" name="idSetor" id="idSetor" value="<?= (int)$registro['idSetor'] ?>"></div>

                        <div id="centro-base">
                            <div class="lado-esquerdo-editar-ramal">
                                <div>
                                    <label for="setor">Setor <span class="label-asterisco">*</span></label>
                                    <span id='spanSetor' class="nao-visivel">Ex: SETOR X ou SETOR-X</span>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="setor" id="setor" value="<?= e((string)$registro['setor']) ?>"
                                    maxlength="35" autocomplete="off" autocorrect="off" placeholder="Informe o setor" required
                                    onkeyup="verificarTextoSetor()">
                                </div>

                                <div>
                                    <label for="ramal">Ramal <span class="label-asterisco">*</span></label>
                                    <span id='spanRamal' class="nao-visivel">Informe apenas números</span>
                                </div>
                                <div>
                                    <?php $ramalEdicao = ($registro['ramal'] == 0) ? '' : $registro['ramal']; ?>
                                    <input class="campo-formulario" type="text" name="ramal" id="ramal" value="<?= e((string)$ramalEdicao) ?>"
                                    maxlength="14" autocomplete="off" autocorrect="off" placeholder="Informe o ramal" required
                                    onkeyup="verificarTextoRamal()">
                                </div>

                                <div>
                                    <label for="responsavel">Responsável</label>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="responsavel" id="responsavel" value="<?= e((string)($registro['responsavel'] ?? '')) ?>"
                                    maxlength="25" autocomplete="off" autocorrect="off" placeholder="Informe o responsavel">
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>

                        <div class="botoes-rodape-editar-ramal">
                            <?php echo campo_csrf(); // P-07 ?>
                            <input class="enviar-submit" type="submit" value="Salvar">
                            <input class="limpar-submit" type="reset" value="Restaurar">
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
</html>
