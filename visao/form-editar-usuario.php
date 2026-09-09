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

// P-04: data comes from the DATABASE by id - never from the URL
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
        <title>Listagem de Ramais - Editar usuário</title>
    </head>

    <body>
        <div id="principal">
            <?php include_once "topo.php" ?>

            <div id="formulario-editar-usuario">
                <form method="post" action="../controle/controle-editar-usuario.php">
                    <div class="formata-btn-home"> <a href="../index.php">Home</a> </div>
                    <div class="formata-btn-home"> <a href="listar-usuarios.php">Voltar</a> </div>
                    <fieldset>
                        <legend><span class="formata-font">Editar usuário</span></legend>
                        <div><input type="hidden" name="id" id="id" value="<?= (int)$registro['id'] ?>"></div>

                        <div class="esquerdo-direito-form-usuario">
                            <div class="lado-esquerdo-form-usuario">
                                <div>
                                    <label for="usuario">Usuário</label>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="usuario" id="usuario" value="<?= e((string)$registro['usuario']) ?>" readonly>
                                </div>
                            </div>

                            <div class="lado-direito-form-usuario">
                                <div>
                                    <label for="email">E-mail</label>
                                </div>
                                <div>
                                    <input class="campo-formulario" type="text" name="email" id="email" value="<?= e((string)($registro['email'] ?? '')) ?>" placeholder="Informe o novo email">
                                </div>

                                <div>
                                    <label for="nivel">Nivel de acesso <span class="label-asterisco">*</span></label>
                                </div>
                                <div>
                                    <select name="nivel" id="nivel" required>
                                        <option disabled value="">Escolha um nível</option>
                                        <option value="admin" <?= ($registro['nivel'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
                                        <option value="atendente" <?= ($registro['nivel'] === 'atendente') ? 'selected' : '' ?>>Atentente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div><p class="formata-texto-campo-obrigatorio"><span class="label-asterisco">*</span> Campo(s) de preenchimento obrigatório.</p></div>

                        <div class="botoes-rodape-editar-usuarios">
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
