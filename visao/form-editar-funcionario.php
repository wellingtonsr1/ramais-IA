<?php
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/validador-acesso-admin.php'; // P-04: guard was missing
require_once __DIR__ . '/../controle/controle-listar-ramais.php';
require_once __DIR__ . '/../modelo/buscar-funcionario.php';
cabecalhos_seguranca();

// first access?
if (($_SESSION['primeiroacesso'] ?? '') === 'sim') {
    redirecionar('form-alterar-senha.php');
}

// P-04: data comes from the DATABASE by id - never from the URL
$idFunc = requisicao_id('idFunc');
$registro = ($idFunc !== null) ? buscarFuncionarioPorId($idFunc) : null;
if ($registro === null) {
    redirecionar('listar-funcionarios.php');
}

$setores = pegarListaSetores();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <?php include "favicon.php"; ?>
        <title>Listagem de Ramais - Editar funcionário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-cadastro">
                <form method="post" action="../controle/controle-editar-funcionario.php">
                    <div class="formata-btn-home"><a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"><a href="listar-funcionarios.php">Voltar</a></div>
                    <div class="clear"></div>
                    <fieldset>
                        <legend><span class="formata-font">Editar Funcionário</span></legend>
                        <div><input type="hidden" name="idFunc" id="idFunc" value="<?= (int)$registro['idFunc'] ?>"></div>
                        <div class="lado-esquerdo">
                            <div>
                                <label for="nome">Nome <span class="label-asterisco">*</span></label>
                                <span id='spanFuncionario' class="nao-visivel">Ex: João, João Silva ou João da Silva</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="nome" id="nome" value="<?= e((string)$registro['nome']) ?>" maxlength="25"
                                autocomplete="off" autocorrect="off" autofocus placeholder="Informe um nome" required
                                onkeyup="verificarTextoFuncionario()">
                            </div>

                            <div>
                                <label for="telefone">Telefone</label>
                                <span id='spanTelefone' class="nao-visivel">Ex: (99) 99999-9999</span>
                            </div>
                            <div>
                                <input class="campo-formulario" type="text" name="telefone" id="telefone" value="<?= e((string)($registro['telefone'] ?? '')) ?>" maxlength="25"
                                autocomplete="off" autocorrect="off" placeholder="Informe um telefone" required
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
                                        <?php $idSetorAtual = (int)$dadosSetor['idSetor']; ?>
                                        <?php if ((int)$registro['idSetor'] === $idSetorAtual): ?>
                                            <option selected value="<?= $idSetorAtual ?>"> <?= e((string)$dadosSetor['setor']) ?></option>
                                        <?php else: ?>
                                            <option value="<?= $idSetorAtual ?>"> <?= e((string)$dadosSetor['setor']) ?></option>
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
                            <input class="limpar-submit" type="reset" value="Restaurar">
                        </div>
                    </fieldset>
                </form>
                <?php include_once "rodape.php" ?>
            </div>
        </div>
    </body>
    <?php include "../includes/cdns.php"; // jQuery + mask ?>
    <script type="text/javascript">
        $("#telefone").mask("(00) 00000-0000");
    </script>
</html>
