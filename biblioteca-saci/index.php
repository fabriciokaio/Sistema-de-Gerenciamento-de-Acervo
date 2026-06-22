<?php
// Carrega os livros do arquivo JSON
$arquivo = 'dados/livros.json';
$livros = [];

if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $livros = json_decode($conteudo, true);
    if ($livros === null) $livros = [];
}

// Calcula estatísticas do dashboard
$totalLivros = count($livros);
$somaAvaliacoes = 0;
$categorias = [];

foreach ($livros as $livro) {
    $somaAvaliacoes += intval($livro['avaliacao']);
    $cat = $livro['categoria'];
    if (!isset($categorias[$cat])) {
        $categorias[$cat] = 0;
    }
    $categorias[$cat]++;
}

$mediaAvaliacoes = $totalLivros > 0 ? round($somaAvaliacoes / $totalLivros, 1) : 0;
$categoriaMaisPopular = '-';
if (!empty($categorias)) {
    arsort($categorias);
    $categoriaMaisPopular = array_key_first($categorias);
}

// Livro da semana: o com maior avaliação
$livroDaSemana = null;
if (!empty($livros)) {
    usort($livros, function($a, $b) {
        return intval($b['avaliacao']) - intval($a['avaliacao']);
    });
    $livroDaSemana = $livros[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca do Saci</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="{css,js,ajax,dados,imagens}/favicon.png">
</head>
<body>

<header>
    <div class="header-content">
        <h1>Biblioteca do Saci</h1>
        <p>Catálogo Digital de Livros Folclóricos</p>
    </div>
    <nav>
        <ul>
            <li><a href="index.php" class="ativo">Início</a></li>
            <li><a href="cadastro.php">Cadastrar Livro</a></li>
            <li><a href="listar.php">Ver Todos</a></li>
        </ul>
    </nav>
</header>

<main>

    <!-- DASHBOARD DE ESTATÍSTICAS -->
    <section id="dashboard">
        <h2>Painel de Estatísticas</h2>
        <div class="cards-estatisticas">
            <div class="card-stat">
                <span class="numero"><?php echo $totalLivros; ?></span>
                <span class="label">Livros Cadastrados</span>
            </div>
            <div class="card-stat">
                <span class="numero"><?php echo $mediaAvaliacoes; ?></span>
                <span class="label">Média de Avaliações</span>
            </div>
            <div class="card-stat">
                <span class="numero"><?php echo $categoriaMaisPopular; ?></span>
                <span class="label">Categoria Popular</span>
            </div>
        </div>
    </section>

    <!-- LIVRO DA SEMANA -->
    <?php if ($livroDaSemana): ?>
    <section id="livro-semana">
        <h2>Livro da Semana</h2>
        <div class="destaque-livro">
            <div class="destaque-info">
                <h3><?php echo htmlspecialchars($livroDaSemana['titulo']); ?></h3>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($livroDaSemana['autor']); ?></p>
                <p><strong>Categoria:</strong> <?php echo htmlspecialchars($livroDaSemana['categoria']); ?></p>
                <p><strong>Ano:</strong> <?php echo htmlspecialchars($livroDaSemana['ano']); ?></p>
                <p><strong>Avaliação:</strong>
                    <?php
                    $av = intval($livroDaSemana['avaliacao']);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $av ? '★' : '☆';
                    }
                    ?>
                </p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- BUSCA RÁPIDA COM AJAX -->
    <section id="busca-rapida">
        <h2>Buscar Livros</h2>
        <div class="form-busca">
            <input type="text" id="campoBusca" placeholder="Digite o título ou autor do livro..." onkeyup="buscarLivros()">
        </div>
        <div id="resultadoBusca"></div>
    </section>

    <!-- CATEGORIAS DISPONÍVEIS -->
    <section id="categorias">
        <h2>Categorias do Acervo</h2>
        <ul class="lista-categorias">
            <li>📖 Fantasia</li>
            <li>👻 Terror</li>
            <li>🚀 Ficção Científica</li>
            <li>💑 Romance</li>
            <li>🔍 Mistério</li>
            <li>📜 Histórico</li>
            <li>💡 Autoajuda</li>
            <li>📚 Outro</li>
        </ul>
        <p>Acesse <a href="listar.php">Ver Todos</a> para filtrar por categoria.</p>
    </section>

    <!-- LISTA DE INSTRUÇÕES DO SISTEMA -->
    <section id="como-usar">
        <h2>Como usar o sistema</h2>
        <ol class="lista-instrucoes">
            <li>Clique em <strong>Cadastrar Livro</strong> para adicionar um novo livro ao acervo.</li>
            <li>Use a <strong>busca rápida</strong> acima para encontrar livros pelo título ou autor.</li>
            <li>Acesse <strong>Ver Todos</strong> para visualizar, editar ou excluir livros.</li>
            <li>Acompanhe as estatísticas no painel de resumo.</li>
        </ol>
    </section>

</main>

<footer>
    <p>Biblioteca do Saci, 2026 — Trabalho de Desenvolvimento Web</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>
