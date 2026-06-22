<?php
$arquivo = 'dados/livros.json';
$livros = [];

if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $livros = json_decode($conteudo, true);
    if ($livros === null) $livros = [];
}

// Filtro por categoria via GET
$filtroCat = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if ($filtroCat !== '') {
    $livros = array_filter($livros, function($l) use ($filtroCat) {
        return $l['categoria'] === $filtroCat;
    });
}

// Lista de categorias únicas para o filtro
$todasCategorias = [];
if (file_exists($arquivo)) {
    $todos = json_decode(file_get_contents($arquivo), true) ?? [];
    foreach ($todos as $l) {
        if (!in_array($l['categoria'], $todasCategorias)) {
            $todasCategorias[] = $l['categoria'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Livros - Biblioteca do Saci</title>
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
        <h2>Acervo Completo</h2>

        <!-- Filtro por categoria -->
        <div class="filtro-categoria">
            <form action="listar.php" method="GET">
                <label for="categoria">Filtrar por categoria:</label>
                <select name="categoria" id="categoriaFiltro" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    <?php foreach ($todasCategorias as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>"
                            <?php echo $filtroCat === $cat ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <?php if (empty($livros)): ?>
            <p class="aviso">Nenhum livro encontrado. <a href="cadastro.php">Cadastre o primeiro!</a></p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Ano</th>
                    <th>Avaliação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                <tr>
                    <td><?php echo $livro['id']; ?></td>
                    <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                    <td><?php echo htmlspecialchars($livro['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($livro['ano']); ?></td>
                    <td>
                        <?php
                        $av = intval($livro['avaliacao']);
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $av ? '★' : '☆';
                        }
                        ?>
                    </td>
                    <td class="acoes">
                        <a href="editar.php?id=<?php echo $livro['id']; ?>" class="btn-editar">Editar</a>
                        <a href="excluir.php?id=<?php echo $livro['id']; ?>"
                           class="btn-excluir"
                           onclick="return confirmarExclusao()">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <p><a href="cadastro.php" class="btn-adicionar">+ Adicionar novo livro</a></p>
    </section>
</main>

<footer>
    <p>Biblioteca do Saci, 2026 — Trabalho de Desenvolvimento Web</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>
