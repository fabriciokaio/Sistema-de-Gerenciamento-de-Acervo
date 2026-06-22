# Biblioteca do Saci - Sistema de Gerenciamento de Acervo

Sistema web de gerenciamento de acervo bibliográfico, desenvolvido como projeto avaliativo da disciplina de Desenvolvimento Web (ARA0062) na Faculdade Estácio.

A temática é inspirada no folclore brasileiro, tendo o Saci como identidade visual do projeto.

---

## Sobre o projeto

A Biblioteca do Saci permite cadastrar, listar, editar e excluir livros de um acervo fictício. Os dados são armazenados em um arquivo JSON, sem necessidade de banco de dados relacional. A busca na página inicial funciona de forma dinâmica, sem recarregar a página, utilizando AJAX.

---

## Tecnologias utilizadas

- **HTML5** — estrutura semântica das páginas
- **CSS3** — estilização e responsividade (arquivo único `style.css`)
- **JavaScript** — validação de formulários, confirmação de exclusão e busca assíncrona via `XMLHttpRequest`
- **PHP** — lógica de servidor, leitura e escrita do arquivo JSON
- **JSON** — persistência dos dados dos livros
- **AJAX** — busca em tempo real sem recarregamento de página

Nenhuma biblioteca externa ou framework foi utilizado.

---

## Estrutura de arquivos

```
saci/
├── index.php           # Página inicial: estatísticas, livro da semana e busca AJAX
├── cadastro.php        # Formulário para cadastrar novos livros
├── listar.php          # Listagem completa do acervo com filtro por categoria
├── editar.php          # Formulário para editar um livro existente
├── excluir.php         # Script de exclusão de livro por ID
├── ajax/
│   └── busca.php       # Endpoint que retorna resultados da busca em JSON
├── js/
│   └── script.js       # Validações e requisição AJAX
├── css/
│   └── style.css       # Estilos do sistema
└── dados/
    └── livros.json     # Arquivo de dados dos livros
```

---

## Funcionalidades

- Cadastro de livros com os campos: título, autor, categoria, ano de publicação e avaliação
- Listagem do acervo com filtro por categoria
- Edição dos dados de qualquer livro cadastrado
- Exclusão de livros com confirmação antes de remover
- Busca dinâmica via AJAX na página inicial, com resultados em tempo real
- Painel de estatísticas e destaque para o livro da semana

---

## Como executar

É necessário um servidor com suporte a PHP (versão 7.4 ou superior).

**Com PHP embutido:**

```bash
cd saci
php -S localhost:8000
```

Depois, acesse `http://localhost:8000` no navegador.

**Com XAMPP, WAMP ou similar:**

Copie a pasta `saci/` para o diretório `htdocs` (XAMPP) ou `www` (WAMP) e acesse pelo navegador.

---

## Modelo de dados

Cada livro é armazenado no arquivo `dados/livros.json` com a seguinte estrutura:

```json
{
  "id": 1,
  "titulo": "Nome do Livro",
  "autor": "Nome do Autor",
  "categoria": "Categoria",
  "ano": 2024,
  "avaliacao": 5
}
```

---

## Autores

- Graziela Brazão
- Fabrício Kaio

**Orientador:** Gabriel Matos  
**Instituição:** Faculdade Estácio
**Ano:** 2026
