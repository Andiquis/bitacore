<?php
// Conectar a la base de datos SQLite
$db = new PDO('sqlite:bitacora.db');

// Procesar el formulario al enviar una nueva entrada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $fecha = $_POST['fecha'];
    $titulo = $_POST['titulo'];
    $subtemas = $_POST['subtemas'];
    $contenido = $_POST['contenido'];

    // Insertar nueva entrada en la base de datos
    $stmt = $db->prepare("INSERT INTO bitacora (fecha, titulo, subtemas, contenido) VALUES (?, ?, ?, ?)");
    $stmt->execute([$fecha, $titulo, $subtemas, $contenido]);

    echo "<p>¡Entrada agregada con éxito!</p>";
}

// Eliminar una entrada
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Eliminar la entrada de la base de datos
    $stmt = $db->prepare("DELETE FROM bitacora WHERE id = ?");
    $stmt->execute([$id]);

    echo "<p>¡Entrada eliminada con éxito!</p>";
}

// Obtener todas las entradas de la bitácora
$entries = $db->query("SELECT * FROM bitacora ORDER BY fecha DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora Web Profesional</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Bitácora Web Profesional</h1>

    <h2>Agregar Nueva Entrada</h2>
    <form method="POST" action="bitacora.php">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required><br>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Escribe el título" required><br>

        <label for="subtemas">Subtemas:</label>
        <input type="text" id="subtemas" name="subtemas" placeholder="Ej: Proyecto, Reunión"><br>

        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="6" placeholder="Escribe el contenido de la entrada" required></textarea><br>

        <button type="submit" name="crear">Guardar Entrada</button>
    </form>

    <h2>Entradas Recientes</h2>
    <?php if (count($entries) > 0): ?>
        <ul>
            <?php foreach ($entries as $entry): ?>
                <li>
                    <strong><?php echo htmlspecialchars($entry['fecha']); ?> - <?php echo htmlspecialchars($entry['titulo']); ?></strong><br>
                    <em>Subtemas: <?php echo htmlspecialchars($entry['subtemas']); ?></em><br>
                    <p><?php echo nl2br(htmlspecialchars($entry['contenido'])); ?></p>
                    <!-- Acciones de editar y eliminar -->
                    <a href="editar.php?id=<?php echo $entry['id']; ?>">Editar</a> | 
                    <a href="bitacora.php?eliminar=<?php echo $entry['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta entrada?');">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay entradas en la bitácora todavía.</p>
    <?php endif; ?>
</body>
</html>
