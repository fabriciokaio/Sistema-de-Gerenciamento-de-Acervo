<?php
// Endpoint AJAX para busca de livros sem recarregar a página

header('Content-Type: application/json; charset=utf-8');

$arquivo = '../dados/livros.json';
$livros = [];

if (file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true) ?? [];
}

$termo = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$resultados = [];

if ($termo !== '') {
    // Estrutura de repetição para filtrar os livros
    foreach ($livros as $livro) {
        $titulo = strtolower($livro['titulo']);
        $autor  = strtolower($livro['autor']);

        // Estrutura condicional: verifica se o termo está no título ou autor
        if (strpos($titulo, $termo) !== false || strpos($autor, $termo) !== false) {
            $resultados[] = $livro;
        }
    }
}

echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
?>
