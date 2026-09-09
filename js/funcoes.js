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
    let pattRamal = /^[0-9]+$/;
    document.getElementById("spanRamal").className =
        (input.value !== '' && !pattRamal.test(input.value)) ? "visivel" : "nao-visivel";
}

// Setor
function verificarTextoSetor() {
    const input = document.getElementById('setor');
    let pattSetor = /^[A-Za-z0-9à-úÀ-ÚçÇ][A-Za-z0-9à-úÀ-ÚçÇ\s\/\.\-_]{0,34}$/;
    document.getElementById("spanSetor").className =
        (input.value !== '' && !pattSetor.test(input.value)) ? "visivel" : "nao-visivel";
}

// Responsavel
function verificarTextoResponsavel() {
    const input = document.getElementById('responsavel');
    let pattResponsavel = /^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\s\/\.\-]{0,24}$/;
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
    let pattNome = /^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\s\/\.\-]{0,38}$/;
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
