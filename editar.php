<?php
// Conectar a la base de datos SQLite
$db = new PDO('sqlite:bitacora.db');
include "crear_db.php";

// Obtener el ID de la entrada a editar
$id = $_GET['id'];

// Obtener la entrada existente
$stmt = $db->prepare("SELECT * FROM bitacora WHERE id = ?");
$stmt->execute([$id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $titulo = $_POST['titulo'];
    $subtemas = $_POST['subtemas'];
    $contenido = $_POST['contenido'];

    // Actualizar la entrada en la base de datos
    $stmt = $db->prepare("UPDATE bitacora SET fecha = ?, titulo = ?, subtemas = ?, contenido = ? WHERE id = ?");
    $stmt->execute([$fecha, $titulo, $subtemas, $contenido, $id]);

    echo "<p>¡Entrada actualizada con éxito!</p>";
    header('Location: bitacora.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrada</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Editar Entrada</h1>

    <form method="POST" action="editar.php?id=<?php echo $id; ?>">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($entry['fecha']); ?>" required><br>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($entry['titulo']); ?>" required><br>

        <label for="subtemas">Subtemas:</label>
        <input type="text" id="subtemas" name="subtemas" value="<?php echo htmlspecialchars($entry['subtemas']); ?>"><br>

        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="6" required><?php echo htmlspecialchars($entry['contenido']); ?></textarea><br>

        <button type="submit">Actualizar Entrada</button>
    </form>
</body>
</html>
