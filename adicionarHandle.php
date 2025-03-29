<?php
require 'db.php';

try {
    $db = new PDO($dsn, $fields["user"], $fields["pass"], $options);

    //$stmt = $db->query("SELECT VERSION()");
    //$version = $stmt->fetchColumn();
    //echo "<p>Conexão bem-sucedida. Versão do servidor: $version</p>";

    $titulo    = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $autor     = $_POST['autor'];
    $editora   = $_POST['editora'];
    $tema      = $_POST['tema'];
    $lido      = isset($_POST['lido']) ? 1 : 0;
    $lingua    = $_POST['lingua'];

    $sql = "INSERT INTO Livro (titulo, subtitulo, autor, editora, tema, lido, lingua)
            VALUES (:titulo, :subtitulo, :autor, :editora, :tema, :lido, :lingua)";
    $stmt = $db->prepare($sql);

    $stmt->execute([
        ':titulo'    => $titulo,
        ':subtitulo' => $subtitulo,
        ':autor'     => $autor,
        ':editora'   => $editora,
        ':tema'      => $tema,
        ':lido'      => $lido,
        ':lingua'    => $lingua
    ]);

    echo "<p>$titulo inserido com sucesso!</p>";
    echo "<p>O que deseja fazer agora?</p>";
    echo "<ul>";
    echo "<li><a href='adicionar.html'>Adicionar outro livro</a></li>";
    echo "<li><a href='ver.php'>Ver lista de livros</a></li>";
    echo "</ul>";
} catch (PDOException $e) {
    echo "<p>Erro na conexão ou na inserção: " . $e->getMessage() . "</p>";
}
?>