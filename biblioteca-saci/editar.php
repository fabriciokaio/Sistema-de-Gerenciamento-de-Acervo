<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$arquivo = 'dados/livros.json';
$livros = [];
$mensagem = '';
$tipoMensagem = '';

if (file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true) ?? [];
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Encontra o índice do livro pelo ID
$indice = -1;
foreach ($livros as $i => $l) {
    if ($l['id'] === $id) {
        $indice = $i;
        break;
    }
}

if ($indice === -1) {
    header('Location: listar.php');
    exit;
}

$livro = $livros[$indice];

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo'] ?? '');
    $autor     = trim($_POST['autor'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $ano       = trim($_POST['ano'] ?? '');
    $avaliacao = trim($_POST['avaliacao'] ?? '');

    if (empty($titulo) || empty($autor) || empty($categoria) || empty($ano) || empty($avaliacao)) {
        $mensagem = 'Preencha todos os campos.';
        $tipoMensagem = 'erro';
    } else {
        $livros[$indice] = [
            'id'        => $id,
            'titulo'    => $titulo,
            'autor'     => $autor,
            'categoria' => $categoria,
            'ano'       => $ano,
            'avaliacao' => $avaliacao
        ];

        file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header('Location: listar.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - Biblioteca do Saci</title>
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
            <li><a href="cadastro.php">Cadastrar Livro</a></li>
            <li><a href="listar.php" class="ativo">Ver Todos</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Editar Livro</h2>

        <?php if ($mensagem): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form id="formEditar" action="editar.php?id=<?php echo $id; ?>" method="POST" onsubmit="return validarFormulario()">

            <div class="campo">
                <label for="titulo">Título do Livro *</label>
                <input type="text" id="titulo" name="titulo"
                       value="<?php echo htmlspecialchars($livro['titulo']); ?>">
            </div>

            <div class="campo">
                <label for="autor">Autor *</label>
                <input type="text" id="autor" name="autor"
                       value="<?php echo htmlspecialchars($livro['autor']); ?>">
            </div>

            <div class="campo">
                <label for="categoria">Categoria *</label>
                <select id="categoria" name="categoria">
                    <option value="">-- Selecione --</option>
                    <?php
                    $cats = ['Fantasia','Terror','Ficção Científica','Romance','Mistério','Histórico','Autoajuda','Outro'];
                    foreach ($cats as $c):
                    ?>
                    <option value="<?php echo $c; ?>"
                        <?php echo $livro['categoria'] === $c ? 'selected' : ''; ?>>
                        <?php echo $c; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="ano">Ano de Publicação *</label>
                <input type="number" id="ano" name="ano"
                       value="<?php echo htmlspecialchars($livro['ano']); ?>"
                       min="1000" max="2099">
            </div>

            <div class="campo">
                <label for="avaliacao">Avaliação (1 a 5 estrelas) *</label>
                <select id="avaliacao" name="avaliacao">
                    <?php for ($v = 1; $v <= 5; $v++): ?>
                    <option value="<?php echo $v; ?>"
                        <?php echo intval($livro['avaliacao']) === $v ? 'selected' : ''; ?>>
                        <?php echo str_repeat('★', $v) . str_repeat('☆', 5 - $v) . " ($v)"; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="botoes-form">
                <button type="submit">Salvar Alterações</button>
                <a href="listar.php" class="btn-secundario">Cancelar</a>
            </div>

        </form>
    </section>
</main>

<footer>
    <p>Biblioteca do Saci &copy; 2025 — Trabalho de Desenvolvimento Web</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>
