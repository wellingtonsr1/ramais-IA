// Helper para filtrar a tabela de ramais pelo ramal
// Usado pela listagem e pelas páginas de filtro/pesquisa de ramal.
window.filtrarTabelaPorRamalHelper = function (idCampoSetor, idMensagem) {
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
    let qualquerVisivel = false;
    const normalizar = (s) => s.toLowerCase().normalize('NFD').replace(/[\\u0300-\\u036f]/g, '');

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
};
