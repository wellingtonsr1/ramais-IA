function mostrarSenha(senha_1, senha_2) {
    if (senha_1 || senha_2) {
        if (senha_1 == 'senha') {
            let tipo = document.getElementById(senha_1);
            tipo.type = (tipo.type == "password") ? "text" : "password";
        } else {
            let tipoNovaSenha = document.getElementById(senha_1);
            let tipoSenhaConfirmada = document.getElementById(senha_2);
            tipoNovaSenha.type = (tipoNovaSenha.type == "password") ? "text" : "password";
            tipoSenhaConfirmada.type = tipoNovaSenha.type;
        }
    }
}

// Ramal: digits only (hint shown; the value is NO LONGER wiped on each keyup - UX fix)
function verificarTextoRamal() {
    const input = document.getElementById('ramal');
    if (!input) {
        return;
    }
    let pattRamal = /^[0-9]+$/;
    const span = document.getElementById('spanRamal');
    const spanInvalido = document.getElementById('spanRamalInvalido');
    const atual = input.value.trim();

    if (atual === '') {
        if (span) {
            span.className = 'nao-visivel';
        }
        if (spanInvalido) {
            spanInvalido.className = 'nao-visivel';
        }
        return;
    }

    const valido = pattRamal.test(atual);
    if (span) {
        span.className = valido ? 'visivel' : 'nao-visivel';
    }
    if (spanInvalido) {
        spanInvalido.className = valido ? 'nao-visivel' : 'visivel';
    }
}

// Setor
function verificarTextoSetor() {
    const input = document.getElementById('setor');
    let pattSetor = /^[A-Za-z0-9à-úÀ-ÚçÇ][A-Za-z0-9à-úÀ-ÚçÇ\\s\\/\\.\\-_]{0,34}$/;
    document.getElementById("spanSetor").className =
        (input.value !== '' && !pattSetor.test(input.value)) ? "visivel" : "nao-visivel";
}

// Responsavel
function verificarTextoResponsavel() {
    const input = document.getElementById('responsavel');
    let pattResponsavel = /^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\\s\\/\\.\\-]{0,24}$/;
    document.getElementById("spanResponsavel").className =
        (input.value !== '' && !pattResponsavel.test(input.value)) ? "visivel" : "nao-visivel";
}

// Usuario
function verificarTextoUsuario() {
    const input = document.getElementById('usuario');
    let pattUsuario = /^[a-z]+([.][a-z]+)*$/;
    document.getElementById("spanUsuario").className =
        (input.value !== '' && !pattUsuario.test(input.value)) ? "visivel" : "nao-visivel";
}

// Funcionario (nome)
function verificarTextoFuncionario() {
    const input = document.getElementById('nome');
    let pattNome = /^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\\s\\/\\.\\-]{0,38}$/;
    document.getElementById("spanFuncionario").className =
        (input.value !== '' && !pattNome.test(input.value)) ? "visivel" : "nao-visivel";
}

// Telefone - P-25: the condition was INVERTED (it wiped the field when the
// number was VALID). Now it only shows the hint when the value is invalid.
function verificarTextoTelefone() {
    const input = document.getElementById('telefone');
    let pattTelefone = /^[0-9]{10,11}$/;
    document.getElementById("spanTelefone").className =
        (input.value !== '' && !pattTelefone.test(input.value)) ? "visivel" : "nao-visivel";
}

// Senha - minimum of 8 characters (P-28)
function verificarTextoSenha() {
    const input = document.getElementById('senha');
    let pattSenha = /^[A-Za-z0-9@$&!#%]{8,}$/;
    document.getElementById("spanSenha").className =
        (input.value !== '' && !pattSenha.test(input.value)) ? "visivel" : "nao-visivel";
}

function verificarTextoNovaSenha() {
    const input = document.getElementById('novaSenha');
    let pattSenha = /^[A-Za-z0-9@$&!#%]{8,}$/;
    document.getElementById('spanNovaSenha').className =
        (input.value !== '' && !pattSenha.test(input.value)) ? "visivel" : "nao-visivel";
}

function verificarTextoSenhaConfirmada() {
    const input = document.getElementById('senhaConfirmada');
    let pattSenha = /^[A-Za-z0-9@$&!#%]{8,}$/;
    document.getElementById('spanSenhaConfirmada').className =
        (input.value !== '' && !pattSenha.test(input.value)) ? "visivel" : "nao-visivel";
}

// Opens a window to display the organogram
function abrirPopup() {
    window.open('organograma.php');
}

/**
 * P-08: confirmation for the DELETE forms (POST + CSRF).
 * Used as onsubmit="return confirmarExclusaoForm(event, 'titulo', 'subtitulo');".
 * When confirmed, the form is submitted programmatically (bypassing onsubmit).
 */
function confirmarExclusaoForm(e, titulo, subTitulo) {
    e.preventDefault();

    Swal.fire({
        position: 'top',
        title: titulo,
        text: subTitulo || '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            e.target.submit();
        }
    });

    return false; // the default submission only happens after confirmation
}

//sucesso na exclusao?
function sucessoDel(pagina) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: 'O registro foi excluído com sucesso!',
            text: 'Dejesa excluir outro?',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/' + pagina;
            } else {
                location.href = '../index.php';
            }
        });
    });
}

//erro na exclusao?
function erroDel(pagina, titulo) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Verifique e tente novamente.',
            type: 'error'
        }).then(() => {
            location.href = '../visao/' + pagina;
        });
    });
}

//sucesso na adicao?
function sucessoAdd(obj) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: 'O registro foi salvo com sucesso!',
            text: 'Dejesa adicionar outro?',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/form-adicionar-' + obj + '.php';
            } else {
                location.href = '../index.php';
            }
        });
    });
}

//erro na adicao?
function erroAdd(obj, titulo) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Voltar e tentar novamente?',
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, voltar',
            cancelButtonText: 'Não, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/form-adicionar-' + obj + '.php';
            } else {
                location.href = '../index.php';
            }
        });
    });
}

//sucesso na edicao?
function sucessoEditar(pagina) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: 'O registro foi alterado com sucesso!',
            text: 'Dejesa alterar outro?',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/' + pagina;
            } else {
                location.href = '../index.php';
            }
        });
    });
}

//erro na edicao?
function erroEditar(pagina, titulo) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Deseja voltar e tentar novamente?',
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, voltar',
            cancelButtonText: 'Não, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/' + pagina;
            } else {
                location.href = '../index.php';
            }
        });
    });
}

// sucesso ao redefinir a senha?
function sucessoSenha(pagina, titulo, subtitulo) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: titulo,
            text: subtitulo,
            type: 'success'
        }).then(() => {
            location.href = pagina;
        });
    });
}

// erro ao alterar/redefinir a senha?
function erroSenha(titulo) {
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Verifique e tente novamente.',
            type: 'error'
        });
    });
}

/* ===================== MELHORIAS 2 e 3 (busca instantanea + limpar filtro) =====================
   Filtra no cliente as linhas da tabela ja carregada, sem recarregar a pagina.
   Nao substitui o envio ao servidor: o formulario continua funcionando
   exatamente como antes (Enter/botao Filtrar). */

function filtrarTabelaInstantanea(idCampo, idMensagem) {
    const campo = document.getElementById(idCampo);
    if (!campo) {
        return true;
    }
    const tabela = campo.closest('div#principal, body')?.querySelector('table.table-container');
    if (!tabela) {
        return true;
    }

    const termo = campo.value.trim().toLowerCase();
    const normalizar = (s) => s.toLowerCase().normalize('NFD').replace(/[\\u0300-\\u036f]/g, '');
    const alvo = normalizar(termo);
    const linhas = tabela.querySelectorAll('tbody tr');
    const mensagem = idMensagem ? document.getElementById(idMensagem) : null;
    let visiveis = 0;

    linhas.forEach(function (linha) {
        const texto = normalizar(linha.textContent || '');
        const casa = alvo === '' || texto.indexOf(alvo) !== -1;
        linha.classList.toggle('oculto-busca', !casa);
        if (casa) {
            visiveis += 1;
        }
    });

    if (mensagem) {
        mensagem.hidden = !(alvo !== '' && visiveis === 0);
    }
    return true;
}

/* Limpa o campo de busca, restaura todas as linhas e esconde a mensagem. */
function limparFiltroTabela(idCampo, idMensagem) {
    const campo = document.getElementById(idCampo);
    if (campo) {
        campo.value = '';
        campo.focus();
    }
    filtrarTabelaInstantanea(idCampo, idMensagem);
    return false; /* nunca envia o formulario */
}

/* Auxilia a busca por número de ramal a partir do campo #ramal.
   Sempre que possível, delega para filtrarTabelaPorRamalHelper (carregado
   pelo topo da página). Isso evita ter que manter três cópias da mesma
   lógica no funcoes.js. */
function filtrarTabelaPorRamal(idCampoSetor, idMensagem) {
    if (typeof filtrarTabelaPorRamalHelper === 'function') {
        return filtrarTabelaPorRamalHelper(idCampoSetor, idMensagem);
    }
    return filtrarTabelaPorRamalFallback(idCampoSetor, idMensagem);
}

/* Fallback caso o helper novo ainda não esteja carregado. */
function filtrarTabelaPorRamalFallback(idCampoSetor, idMensagem) {
    const campoRamal = document.getElementById('ramal');
    if (!campoRamal) {
        return true;
    }
    const tabela = campoRamal.closest('div#principal, body')?.querySelector('table.table-container');
    if (!tabela) {
        return true;
    }
    const termo = campoRamal.value.trim().toLowerCase();
    const colunasRamal = tabela.querySelectorAll('td.ramal');
    const mensagem = idMensagem ? document.getElementById(idMensagem) : null;
    const normalizar = (s) => s.toLowerCase().normalize('NFD').replace(/[\\u0300-\\u036f]/g, '');
    let qualquerVisivel = false;

    colunasRamal.forEach(function (celula) {
        const linha = celula.closest('tr');
        if (!linha) {
            return;
        }
        const valorCelula = (celula.querySelector('.ramal-valor') || celula).textContent || '';
        const casa = termo === '' || normalizar(valorCelula).indexOf(termo) !== -1;
        linha.classList.toggle('oculto-busca', !casa);
        if (casa) {
            qualquerVisivel = true;
        }
    });

    if (mensagem) {
        mensagem.hidden = !(termo !== '' && !qualquerVisivel);
    }
    return true;
}
