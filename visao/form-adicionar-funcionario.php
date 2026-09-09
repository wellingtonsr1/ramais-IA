<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php';
require_once __DIR__ . '/../controle/controle-listar-ramais.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// optional highlight: only via idSetor (setor name in URL is ignored - P-14 class issue)
$setorSelecionado = requisicao_id('idSetor');
$setores = pegarListaSetores();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Adicionar funcionário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-cadastro">
                <form method="post" action="../controle/controle-adicionar-funcionario.php">
                    <div class="formata-btn-home"><a href="../index.php">Home</a> </div>
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Adicionar Funcionário</span></legend>
                        <div class="lado-esquerdo">
                            <div>
                                <label for="nome">Nome <span class="label-asterisco">*</span></label>
                                <span id='spanFuncionario' class="nao-visivel">Ex: João, João Silva ou João da Silva</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="nome" id="nome" maxlength="25"
                                autocomplete="off" autocorrect="off" autofocus placeholder="Informe um nome" required
                                onkeyup="verificarTextoFuncionario()">
                            </div>

                            <div>
                                <label for="telefone">Celular</label>
                                <span id='spanTelefone' class="nao-visivel">Ex: (99) 99999-9999</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="telefone" id="telefone" maxlength="25"
                                autocomplete="off" autocorrect="off" placeholder="(99) 99999-9999 (apenas números)"
                                onkeyup="verificarTextoTelefone()">
                            </div>
                        </div>

                        <div class="lado-direito">
                            <div>
                                <label for="idSetor">Setor <span class="label-asterisco">*</span></label>
                            </div>
                            <div>
                                <select name="idSetor" id="idSetor" required>
                                    <option selected disabled value="">Escolha um setor</option>
                                    <?php foreach ($setores as $dadosSetor): ?>
                                        <?php $idSetor = (int)$dadosSetor['idSetor']; ?>
                                        <?php if ($setorSelecionado !== null && $idSetor === $setorSelecionado): ?>
                                            <option selected value="<?= $idSetor ?>"> <?= e((string)$dadosSetor['setor']) ?></option> <!-- P-20: quoted values -->
                                        <?php else: ?>
                                            <option value="<?= $idSetor ?>"> <?= e((string)$dadosSetor['setor']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>

                        <div class="botoes-rodape-funcionarios">
                            <?php echo campo_csrf(); // P-07 ?>
                            <input class="enviar-submit" type="submit" value="Salvar">
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
            case 'sucessoAdd': ?>
                <script> sucessoAdd('funcionario') </script>
                <?php break;
            case 'erroAdd': ?>
                <script> erroAdd('funcionario', 'Não foi possível salvar os dados!') </script>
                <?php break;
        }
        unset($_SESSION['status']);
    }
    ?>
    <!-- builds the phone mask -->
    <script type="text/javascript">
        $("#telefone").mask("(00) 00000-0000");
    </script>
</html>
