
// Biblioteca do Saci - script.js
var camposObrigatorios = ['titulo', 'autor', 'categoria', 'ano', 'avaliacao'];

/**
 * Valida os formulários de cadastro e edição antes de enviar
 */
function validarFormulario() {
    var erros = [];

    for (var i = 0; i < camposObrigatorios.length; i++) {
        var nomeCampo = camposObrigatorios[i];
        var campo = document.getElementById(nomeCampo);

        if (campo && campo.value.trim() === '') {
            erros.push(nomeCampo);
        }
    }

    if (erros.length > 0) {
        alert('Por favor, preencha todos os campos obrigatórios:\n- ' + erros.join('\n- '));
        return false;
    }

    var campoAno = document.getElementById('ano');
    if (campoAno) {
        var ano = parseInt(campoAno.value);
        if (isNaN(ano) || ano < 1000 || ano > 2099) {
            alert('Informe um ano válido (entre 1000 e 2099).');
            return false;
        }
    }

    return true;
}

/**
 * Confirma antes de excluir um livro
 */
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir este livro? Esta ação não pode ser desfeita.');
}

function buscarLivros() {
    var campo = document.getElementById('campoBusca');
    var resultado = document.getElementById('resultadoBusca');

    if (!campo || !resultado) return;

    var termo = campo.value.trim();

    // Se o campo estiver vazio, limpa os resultados
    if (termo === '') {
        resultado.innerHTML = '';
        return;
    }

    // Cria objeto do AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'ajax/busca.php?q=' + encodeURIComponent(termo), true);

    xhr.onreadystatechange = function () {
        // Verifica se a requisição foi concluída com sucesso
        if (xhr.readyState === 4 && xhr.status === 200) {
            var livros = JSON.parse(xhr.responseText);
            exibirResultados(livros);
        }
    };

    xhr.send();
}

/**
 * Exibe os resultados da busca na página.
 * Usa array e estrutura de repetição.
 */
function exibirResultados(livros) {
    var resultado = document.getElementById('resultadoBusca');

    // Estrutura condicional: verifica se há resultados
    if (livros.length === 0) {
        resultado.innerHTML = '<p class="sem-resultado">Nenhum livro encontrado.</p>';
        return;
    }

    var html = '';

    // Estrutura de repetição: monta HTML para cada livro encontrado
    for (var i = 0; i < livros.length; i++) {
        var livro = livros[i];
        var estrelas = '';

        // Gera as estrelas de avaliação
        for (var e = 1; e <= 5; e++) {
            if (e <= parseInt(livro.avaliacao)) {
                estrelas += '★';
            } else {
                estrelas += '☆';
            }
        }

        html += '<div class="item-busca">';
        html += '<h4>' + livro.titulo + '</h4>';
        html += '<p>Autor: ' + livro.autor + ' | Categoria: ' + livro.categoria + ' | Ano: ' + livro.ano + ' | ' + estrelas + '</p>';
        html += '</div>';
    }

    resultado.innerHTML = html;
}
