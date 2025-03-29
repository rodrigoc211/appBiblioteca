<?php
require 'db.php';

if (!isset($_POST['id'])) {
    die("ID do livro não fornecido.");
}

$id = (int)$_POST['id']; // Conversão para inteiro por segurança

try {
    $db = new PDO($dsn, $fields["user"], $fields["pass"], $options);

    // Executa a exclusão
    $sql = "DELETE FROM Livro WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Redireciona de volta para a listagem após excluir
    header('Location: ver.php?msg=LivroRemovido');
    exit;
} catch (PDOException $e) {
    die("Erro ao excluir livro: " . $e->getMessage());
}
