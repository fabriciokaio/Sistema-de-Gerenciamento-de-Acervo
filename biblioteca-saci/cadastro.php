<?php
$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo'] ?? '');
    $autor     = trim($_POST['autor'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $ano       = trim($_POST['ano'] ?? '');
    $avaliacao = trim($_POST['avaliacao'] ?? '');

    // Validação básica no servidor
    if (empty($titulo) || empty($autor) || empty($categoria) || empty($ano) || empty($avaliacao)) {
        $mensagem = 'Preencha todos os campos obrigatórios.';
        $tipoMensagem = 'erro';
    } else {
        $arquivo = 'dados/livros.json';
        $livros = [];

        if (file_exists($arquivo)) {
            $conteudo = file_get_contents($arquivo);
            $livros = json_decode($conteudo, true);
            if ($livros === null) $livros = [];
        }

        // Gera novo ID
        $novoId = 1;
        if (!empty($livros)) {
            $ids = array_column($livros, 'id');
            $novoId = max($ids) + 1;
        }

        $novoLivro = [
            'id'        => $novoId,
            'titulo'    => $titulo,
            'autor'     => $autor,
            'categoria' => $categoria,
            'ano'       => $ano,
            'avaliacao' => $avaliacao
        ];

        $livros[] = $novoLivro;
        file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $mensagem = 'Livro cadastrado com sucesso!';
        $tipoMensagem = 'sucesso';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro - Biblioteca do Saci</title>
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
            <li><a href="index.php">Início</a></li>
            <li><a href="cadastro.php" class="ativo">Cadastrar Livro</a></li>
            <li><a href="listar.php">Ver Todos</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Cadastrar Novo Livro</h2>

        <?php if ($mensagem): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form id="formCadastro" action="cadastro.php" method="POST" onsubmit="return validarFormulario()">

            <div class="campo">
                <label for="titulo">Título do Livro *</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ex: Pé de Pano">
            </div>

            <div class="campo">
                <label for="autor">Autor *</label>
                <input type="text" id="autor" name="autor" placeholder="Ex: Esmeraldina dos Santos">
            </div>

            <div class="campo">
                <label for="categoria">Categoria *</label>
                <select id="categoria" name="categoria">
                    <option value="">-- Selecionar --</option>
                    <option value="Fantasia">Fantasia</option>
                    <option value="Terror">Terror</option>
                    <option value="Ficção Científica">Ficção Científica</option>
                    <option value="Romance">Romance</option>
                    <option value="Mistério">Mistério</option>
                    <option value="Histórico">Histórico</option>
                    <option value="Autoajuda">Autoajuda</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="ano">Ano de Publicação *</label>
                <input type="number" id="ano" name="ano" placeholder="Ex: 1899" min="1000" max="2099">
            </div>

            <div class="campo">
                <label for="avaliacao">Avaliação (1 a 5 estrelas) *</label>
                <select id="avaliacao" name="avaliacao">
                    <option value="">-- Selecione --</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="5">★★★★★ (5)</option>
                </select>
            </div>

            <div class="botoes-form">
                <button type="submit">Cadastrar</button>
                <a href="index.php" class="btn-secundario">Cancelar</a>
            </div>

        </form>
    </section>
</main>

<footer>
    <p>Biblioteca do Saci, 2026 — Trabalho de Desenvolvimento Web</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>
