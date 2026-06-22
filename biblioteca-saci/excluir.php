<?php
$arquivo = 'dados/livros.json';

if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = intval($_GET['id']);
$livros = [];

if (file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true) ?? [];
}

// Remove o livro com o ID correspondente
$livros = array_filter($livros, function($l) use ($id) {
    return $l['id'] !== $id;
});

// Re-indexa o array
$livros = array_values($livros);

file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: listar.php');
exit;
?>
