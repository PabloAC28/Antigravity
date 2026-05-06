<?php
require_once 'auth_check.php';
require_login();
require_once 'config.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Procesar el formulario si se envió
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $id_marca = intval($_POST['id_marca'] ?? 0);
    $id_post = intval($_POST['id'] ?? 0);

    if ($nombre !== '' && $id_marca > 0 && $id_post > 0) {
        $update_query = "UPDATE componentes SET nombre = :nombre, precio = :precio, stock = :stock, id_marca = :id_marca WHERE id = :id";
        $update_stmt = $pdo->prepare($update_query);
        $result = $update_stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':stock' => $stock,
            ':id_marca' => $id_marca,
            ':id' => $id_post
        ]);

        if ($result) {
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Error al actualizar el componente.";
        }
    } else {
        $mensaje = "Por favor, completa los campos requeridos.";
    }
}

// Obtener datos del componente
$stmt = $pdo->prepare("SELECT * FROM componentes WHERE id = :id");
$stmt->execute([':id' => $id]);
$componente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$componente) {
    header("Location: index.php");
    exit;
}

// Obtener todas las marcas para el <select>
$stmt_marcas = $pdo->query("SELECT id_marca, nombre FROM marcas ORDER BY nombre ASC");
$marcas = $stmt_marcas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Componente | Nexus Hardware</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Editar Componente</h1>
        <p class="subtitle">Modificar inventario en el catálogo</p>
    </header>

    <main class="container form-container">
        <?php if ($mensaje): ?>
            <div style="background: rgba(255, 0, 85, 0.2); border: 1px solid #ff0055; padding: 15px; border-radius: 10px; margin-bottom: 20px; color: #ff0055;">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="editar.php?id=<?php echo $id; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group">
                <label for="nombre">Nombre del Componente</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($componente['nombre']); ?>">
            </div>

            <div class="form-group">
                <label for="id_marca">Marca</label>
                <select id="id_marca" name="id_marca" required>
                    <option value="">-- Selecciona una Marca --</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>" <?php if ($marca['id_marca'] == $componente['id_marca']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($marca['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="precio">Precio ($)</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required value="<?php echo $componente['precio']; ?>">
            </div>

            <div class="form-group">
                <label for="stock">Stock Disponible</label>
                <input type="number" id="stock" name="stock" min="0" required value="<?php echo $componente['stock']; ?>">
            </div>

            <button type="submit" class="btn btn-primary" style="background: #00e5ff; color: #060b19;">Guardar Cambios</button>
            <a href="index.php" class="btn btn-outline" style="text-align: center; display: block; margin-top: 15px;">Cancelar</a>
        </form>
    </main>

</body>
</html>
