<?php
require 'db.php';

try {
    $db = new PDO($dsn, $fields["user"], $fields["pass"], $options);

    $sql = "SELECT id, titulo, subtitulo, autor, editora, tema, lido, lingua FROM Livro";
    $stmt = $db->query($sql);
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao obter livros: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listagem de Livros</title>
    <script src="sorttable.js"></script>
    <style>
        /* Ajuste de estilo básico */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 6px 10px;
            border: 1px solid #ccc;
        }
        th {
            cursor: pointer; /* Indica que a coluna é clicável para ordenação */
        }
    </style>
</head>
<body>
    <h1>Livros disponíveis</h1>

    <table class="sortable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Subtítulo</th>
                <th>Autor</th>
                <th>Editora</th>
                <th>Tema</th>
                <th>Lido</th>
                <th>Língua</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($livros): ?>
            <?php foreach ($livros as $livro): ?>
            <tr>
                <td><?php echo $livro['id']; ?></td>
                <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($livro['subtitulo']); ?></td>
                <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                <td><?php echo htmlspecialchars($livro['editora']); ?></td>
                <td><?php echo htmlspecialchars($livro['tema']); ?></td>
                <td><?php echo $livro['lido'] ? 'Sim' : 'Não'; ?></td>
                <td><?php echo htmlspecialchars($livro['lingua']); ?></td>
                <td>
                    <!-- Botão para Eliminar -->
                    <form action="eliminarLivro.php" method="post" 
                          onsubmit="return confirm('Tem certeza que deseja eliminar este livro?');">
                        <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9">Não há livros registados.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <p>
        <a href="adicionar.html">Adicionar livros</a>
    </p>
</body>
</html>
