function mostrarSenha(senha_1, senha_2){
    if(senha_1 || senha_2){
        if(senha_1 == 'senha'){
            let tipo = document.getElementById(senha_1);
    
            tipo.type = (tipo.type == "password") ? "text" : "password";
        }else{
            let tipoNovaSenha = document.getElementById(senha_1);
            let tipoSenhaConfirmada = document.getElementById(senha_2);
    
            tipoNovaSenha.type = (tipoNovaSenha.type == "password") ? "text" : "password";
            tipoSenhaConfirmada.type = tipoNovaSenha.type
        }
    }
}

//'ramal' do 'adicionar setor'
function verificarTextoRamal() {
    const input = document.getElementById('ramal')
    //input.style.color = ''

    document.getElementById("spanRamal").className = "nao-visivel";

    let texto = input.value
    let pattRamal = /^[0-9]+$/
   
    if(!pattRamal.test(texto)){
        input.value = ''
        document.getElementById("spanRamal").className = "visivel";
        //input.style.color = 'red'
    }   
}

//'setor' do 'adicionar setor'
function verificarTextoSetor() {
    const input = document.getElementById('setor')
    //input.style.color = ''

    document.getElementById("spanSetor").className = "nao-visivel";

    let texto = input.value
    //let pattSetor = /^[A-Za-zà-úÀ-ÚçÇ]+[_\/\.-]?(\s[A-Za-z]{2,3})?(\s?[A-Za-zà-úÀ-ÚçÇ]+)[_\/\.-]?(\s?[A-Za-zà-úÀ-ÚçÇ]+)?[\s\.]?([0-9]+)?$/
    let pattSetor = /^[A-Za-zà-úÀ-ÚçÇ]+([_\/\.-]?(\s[A-Za-z]{2,3})?(\s?[A-Za-zà-úÀ-ÚçÇ]+)[_\/\.-]?(\s?[A-Za-zà-úÀ-ÚçÇ]+)?[\s\.]?([0-9]+)?)?$/
   
    if(!pattSetor.test(texto)){
        input.value = ''
        document.getElementById("spanSetor").className = "visivel";
        //input.style.color = 'red'
    }
}

//'usuario' do 'adicionar usuário'
function verificarTextoResponsavel() {
    const input = document.getElementById('responsavel')

    document.getElementById("spanResponsavel").className = "nao-visivel";
    
    let patterResponsavel = /^[A-Za-zà-úÀ-ÚçÇ]+[\s]?([A-Za-z]+)?[-\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/
  
    if(!patterResponsavel.test(input.value)){
        input.value = ''
        document.getElementById("spanResponsavel").className = "visivel"; 
    }
}

//'usuario' do 'adicionar usuário'
function verificarTextoUsuario() {
    const input = document.getElementById('usuario')

    document.getElementById("spanUsuario").className = "nao-visivel";
    
    let patterUsuario = /^[a-z]+[.]?([a-z]+)?$/
  
    if(!patterUsuario.test(input.value)){
        input.value = ''
        document.getElementById("spanUsuario").className = "visivel"; 
    }
}

//'email' do 'adicionar setor' e 'adicionar usuário'
function verificarTextoEmail() {
    document.getElementById('email').style.color = ''
    let texto = document.getElementById('email').value
    let pattSetor = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]+\.([a-z]+)?$/i
   
    if(!pattSetor.test(texto)){
        document.getElementById('email').value = ''
        document.getElementById('email').style.color = 'red'
    }
}

//'Funcionario' do 'adicionar Funcionario'
function verificarTextoFuncionario() {
    const input = document.getElementById('nome')
    //input.style.color = ''

    document.getElementById("spanFuncionario").className = "nao-visivel";

    let texto = input.value
    //let pattNome = /^[A-Za-zà-úÀ-ÚçÇ]+[\s]?[-]?[\s]?[/]?([A-Za-z]+)?[-\s/]?([A-Za-zà-úÀ-ÚçÇ]+)?$/
    let pattNome = /^[A-Za-zà-úÀ-ÚçÇ]+([\s][A-Za-z]{2,3})?[\s]?([A-Za-zà-úÀ-ÚçÇ]+)?$/

    if(!pattNome.test(texto)){
        input.value = ''
        document.getElementById("spanFuncionario").className = "visivel";
       // input.style.color = 'red'
    }
}

//'usuario' do 'adicionar usuário'
function verificarTextoTelefone() {
    const input = document.getElementById('telefone')

    document.getElementById("spanTelefone").className = "nao-visivel";
    
    //let patterTelefone = /^\([0-9]{2}\)\s[0-9]{4,5}[-][0-9]{4}$/
    let patterTelefone = /^[0-9]{10,11}$/
  
    if(patterTelefone.test(input.value)){
        input.value = ''
        document.getElementById("spanTelefone").className = "visivel"; 
    }
}

//senha do 'adicionar usuário'
function verificarTextoSenha() {
    const input = document.getElementById('senha')

    document.getElementById("spanSenha").className = "nao-visivel";
   
    let texto = input.value
    let pattSenha = /^[A-Za-z0-9@$&!#%]+$/
   
    if(!pattSenha.test(texto)){
        input.value = ''
        document.getElementById("spanSenha").className = "visivel";  
    }   
}

//'novaSenha' do 'alterar senha'
function verificarTextoNovaSenha() {
    const input = document.getElementById('novaSenha')

    document.getElementById('spanNovaSenha').className = 'nao-visivel'

    let novaSenha = input.value
    let pattSenha = /^[A-Za-z0-9@$&!#%]+$/

    if(!pattSenha.test(novaSenha)){
        input.value = ''
        document.getElementById('spanNovaSenha').className = "visivel"
    }
}

//'senhaConfirmada' do 'alterar senha'
function verificarTextoSenhaConfirmada() {
    const input = document.getElementById('senhaConfirmada')
  
    document.getElementById('spanSenhaConfirmada').className = 'nao-visivel'
    
    let senhaConfirmada = input.value
    let pattSenha = /^[A-Za-z0-9@$&!#%]+$/

    if(!pattSenha.test(senhaConfirmada)){
        input.value = ''
        document.getElementById('spanSenhaConfirmada').className = "visivel"
    }  
}

function compararSenhas(x, y) {
    //const inputs = document.getElementsByTagName('input')
    document.getElementById('spanIgualdade').className = 'nao-visivel'

    let valor1 = x //inputs[1].value
    let valor2 = y //inputs[2].value

    if(valor1 != valor2){
        document.getElementById('spanIgualdade').className = 'visivel'
    }
    
}

// Abre uma janela para exibição do organograma
function abrirPopup() {
    window.open('organograma.php')
}

// usado na confirmação da exclusão dos dados. É chamado pelo onclick no botão
function confirmarExclusao(e, titulo, subTitulo){
    e.preventDefault();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    Swal.fire({
        position: 'top',
        title: titulo,
        text: subTitulo,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            location.href = e.target.href;
            sucessoDel('listar-ramais.php')
        }
    })
}

//sucesso na exclusão?
function sucessoDel(pagina){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: 'O registro foi excluído com sucesso!',
            text: 'Dejesa excluir outro?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/'+pagina;
            }else{
                location.href = '../index.php';
            }
        })
    })
}

//erro na exclusão?
function erroDel(pagina, titulo){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Verfique e tente novamente.',
            icon: 'error',
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/'+pagina;
            }
        })
    })
}

//sucesso na adição? 
function sucessoAdd(obj){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: 'O registro foi salvo com sucesso!',
            text: 'Dejesa adicionar outro?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/form-adicionar-' + obj + '.php';
            }else{
                location.href = '../index.php';
            }
        })
    })
}

//erro na adição?
function erroAdd(obj, titulo){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: titulo,
            //title: 'Não foi possível salvar os dados!',
            text: 'Voltar e tentar novamente?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, voltar',
            cancelButtonText: 'Não, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/form-adicionar-'+ obj +'.php';
            }else{
                location.href = '../index.php';   
            }
        })
    })
}

// usado na confirmação da exclusão dos dados. É chamado pelo onclick no botão
function confirmarEdicao(e, obj){
    e.preventDefault();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    Swal.fire({ 
        position: 'top',
        title:  "Deseja alterar os dados de " +obj + " ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, alterar!',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            location.href = e.target.href;
        }
    })
}

//sucesso na edição? 
function sucessoEditar(pagina){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: 'O registro foi alterado com sucesso!',
            text: 'Dejesa alterar outro?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/'+pagina;
            }else{
                location.href = '../index.php';
            }
        })
    })
}

//erro na adição? 
function erroEditar(pagina, titulo){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Deseja voltar e tentar novamente?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, voltar',
            cancelButtonText: 'Não, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = '../visao/'+pagina;
            }else{
                location.href = '../index.php';
            }
        })
    })
}

// sucesso ao editar ou resetar a senha?
function sucessoSenha(pagina, titulo, subtitulo){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: titulo,
            text: subtitulo,
            icon: 'success',
        }).then((result) => {
            if (result.value) {
                location.href = pagina;
            }
        })
    })
}

// erro ao editar ou resetar a senha?
function erroSenha(titulo){
    document.addEventListener('DOMContentLoaded', function () { 
        Swal.fire({
            position: 'top',
            title: titulo,
            text: 'Verifique e tente novamente.',
            icon: 'error',
        })
    })
}
