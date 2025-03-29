<?php
require 'db.php';

try {
    $db = new PDO($dsn, $fields["user"], $fields["pass"], $options);

    // Se o formulário de atualização foi submetido (indicamos com um campo "update")
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $id        = $_POST['id'];
        $titulo    = $_POST['titulo'];
        $subtitulo = $_POST['subtitulo'];
        $autor     = $_POST['autor'];
        $editora   = $_POST['editora'];
        $tema      = $_POST['tema'];
        $lido      = isset($_POST['lido']) ? 1 : 0;
        $lingua    = $_POST['lingua'];

        $sql = "UPDATE Livro 
                SET titulo = :titulo, subtitulo = :subtitulo, autor = :autor, editora = :editora, tema = :tema, lido = :lido, lingua = :lingua
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':titulo'    => $titulo,
            ':subtitulo' => $subtitulo,
            ':autor'     => $autor,
            ':editora'   => $editora,
            ':tema'      => $tema,
            ':lido'      => $lido,
            ':lingua'    => $lingua,
            ':id'        => $id
        ]);

        header('Location: ver.php');
        exit;
    }
    // Se o ID é passado via POST para edição (pré-preenchimento)
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $db->prepare("SELECT * FROM Livro WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $livro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$livro) {
            echo "<p>Livro não encontrado!</p>";
            exit;
        }
?>
        <!DOCTYPE html>
        <html lang="pt">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Livro</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }

                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }

                label {
                    display: block;
                    margin-top: 10px;
                }

                input[type="text"] {
                    width: 100%;
                    padding-top: 10px;
                    margin-top: 5px;
                }

                input[type="checkbox"] {
                    margin-top: 5px;
                }

                input[type="submit"] {
                    margin-top: 20px;
                    padding: 10px 20px;
                    background: #4CAF50;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background: #45a049;
                }

                .formulario {
                    padding: 10px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Editar Livro</h1>
                <form class="formulario" method="post" action="editarLivro.php">
                    <!-- Campo oculto para manter o ID -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">

                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
                    <br>

                    <label for="subtitulo">Subtítulo:</label>
                    <input type="text" name="subtitulo" id="subtitulo" value="<?php echo htmlspecialchars($livro['subtitulo']); ?>">
                    <br>

                    <label for="autor">Autor:</label>
                    <input type="text" name="autor" id="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
                    <br>

                    <label for="editora">Editora:</label>
                    <input type="text" name="editora" id="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>" required>
                    <br>

                    <label for="tema">Tema:</label>
                    <select name="tema" id="tema" required>
                        <option value="História Antiga (Grécia)" <?php echo (!isset($livro['tema']) || $livro['tema'] == "História Antiga (Grécia)") ? 'selected' : ''; ?>>
                            História Antiga (Grécia)
                        </option>
                        <option value="História Antiga (Roma)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Antiga (Roma)") ? 'selected' : ''; ?>>
                            História Antiga (Roma)
                        </option>
                        <option value="História Antiga (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Antiga (Outra)") ? 'selected' : ''; ?>>
                            História Antiga (Outra)
                        </option>
                        <option value="História Medieval (Europa)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Medieval (Europa)") ? 'selected' : ''; ?>>
                            História Medieval (Europa)
                        </option>
                        <option value="História Medieval (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Medieval (Outra)") ? 'selected' : ''; ?>>
                            História Medieval (Outra)
                        </option>
                        <option value="História Moderna (Europa)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Moderna (Europa)") ? 'selected' : ''; ?>>
                            História Moderna (Europa)
                        </option>
                        <option value="História Moderna (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Moderna (Outra)") ? 'selected' : ''; ?>>
                            História Moderna (Outra)
                        </option>
                        <option value="História Contemporânea (Europa)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Contemporânea (Europa)") ? 'selected' : ''; ?>>
                            História Contemporânea (Europa)
                        </option>
                        <option value="História Contemporânea (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Contemporânea (Outra)") ? 'selected' : ''; ?>>
                            História Contemporânea (Outra)
                        </option>
                        <option value="História de Portugal (Medieval)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História de Portugal (Medieval)") ? 'selected' : ''; ?>>
                            História de Portugal (Medieval)
                        </option>
                        <option value="História de Portugal (Moderna)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História de Portugal (Moderna)") ? 'selected' : ''; ?>>
                            História de Portugal (Moderna)
                        </option>
                        <option value="História de Portugal (Contemporânea)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História de Portugal (Contemporânea)") ? 'selected' : ''; ?>>
                            História de Portugal (Contemporânea)
                        </option>
                        <option value="História de Portugal (Militar)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História de Portugal (Militar)") ? 'selected' : ''; ?>>
                            História de Portugal (Militar)
                        </option>
                        <option value="História de Portugal (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História de Portugal (Outra)") ? 'selected' : ''; ?>>
                            História de Portugal (Outra)
                        </option>
                        <option value="História Religiosa (Cruzadas)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Religiosa (Cruzadas)") ? 'selected' : ''; ?>>
                            História Religiosa (Cruzadas)
                        </option>
                        <option value="História Religiosa (Santos)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Religiosa (Santos)") ? 'selected' : ''; ?>>
                            História Religiosa (Santos)
                        </option>
                        <option value="História Religiosa (Outra)" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Religiosa (Outra)") ? 'selected' : ''; ?>>
                            História Religiosa (Outra)
                        </option>
                        <option value="História Política" <?php echo (isset($livro['tema']) && $livro['tema'] == "História Política") ? 'selected' : ''; ?>>
                            História Política
                        </option>
                        <option value="Política" <?php echo (isset($livro['tema']) && $livro['tema'] == "Política") ? 'selected' : ''; ?>>
                            Política
                        </option>
                        <option value="Biografias (Reis)" <?php echo (isset($livro['tema']) && $livro['tema'] == "Biografias (Reis)") ? 'selected' : ''; ?>>
                            Biografias (Reis)
                        </option>
                        <option value="Biografias (Outros)" <?php echo (isset($livro['tema']) && $livro['tema'] == "Biografias (Outros)") ? 'selected' : ''; ?>>
                            Biografias (Outros)
                        </option>
                        <option value="Literatura (Antiga)" <?php echo (isset($livro['tema']) && $livro['tema'] == "Literatura (Antiga)") ? 'selected' : ''; ?>>
                            Literatura (Antiga)
                        </option>
                        <option value="Literatura (Portuguesa)" <?php echo (isset($livro['tema']) && $livro['tema'] == "Literatura (Portuguesa)") ? 'selected' : ''; ?>>
                            Literatura (Portuguesa)
                        </option>
                        <option value="Literatura (Estrangeira)" <?php echo (isset($livro['tema']) && $livro['tema'] == "Literatura (Estrangeira)") ? 'selected' : ''; ?>>
                            Literatura (Estrangeira)
                        </option>
                    </select>
                    <br>

                    <label for="lingua">Língua:</label>
                    <select name="lingua" id="lingua" required>
                        <option value="Português" <?php echo (!isset($livro['lingua']) || $livro['lingua'] == "Português") ? 'selected' : ''; ?>>Português</option>
                        <option value="Francês" <?php echo (isset($livro['lingua']) && $livro['lingua'] == "Francês") ? 'selected' : ''; ?>>Francês</option>
                        <option value="Inglês" <?php echo (isset($livro['lingua']) && $livro['lingua'] == "Inglês") ? 'selected' : ''; ?>>Inglês</option>
                        <option value="Italiano" <?php echo (isset($livro['lingua']) && $livro['lingua'] == "Italiano") ? 'selected' : ''; ?>>Italiano</option>
                        <option value="Grego" <?php echo (isset($livro['lingua']) && $livro['lingua'] == "Grego") ? 'selected' : ''; ?>>Grego</option>
                        <option value="Latim" <?php echo (isset($livro['lingua']) && $livro['lingua'] == "Latim") ? 'selected' : ''; ?>>Latim</option>
                    </select>
                    <br>

                    <label for="lido">Lido: <input type="checkbox" name="lido" id="lido" <?php echo ($livro['lido'] ? 'checked' : ''); ?>></label>
                    <br>
                    <!-- Botão de submissão que indica atualização -->
                    <input type="submit" name="update" value="Atualizar Livro">
                </form>
            </div>
        </body>

        </html>
<?php
    } else {
        echo "<p>ID do livro não informado.</p>";
        exit;
    }
} catch (PDOException $e) {
    echo "<p>Erro: " . $e->getMessage() . "</p>";
}
?>