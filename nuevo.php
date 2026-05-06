<?php
require_once 'auth_check.php';
require_login();
require_once 'config.php';

// Obtener todas las marcas para el <select>
$stmt = $pdo->query("SELECT id_marca, nombre FROM marcas ORDER BY nombre ASC");
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario si se envió
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $id_marca = intval($_POST['id_marca'] ?? 0);

    if ($nombre !== '' && $id_marca > 0) {
        $insert_query = "INSERT INTO componentes (nombre, precio, stock, id_marca) VALUES (:nombre, :precio, :stock, :id_marca)";
        $insert_stmt = $pdo->prepare($insert_query);
        $result = $insert_stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':stock' => $stock,
            ':id_marca' => $id_marca
        ]);

        if ($result) {
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Error al guardar el componente.";
        }
    } else {
        $mensaje = "Por favor, completa los campos requeridos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Componente | Nexus Hardware</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Nuevo Componente</h1>
        <p class="subtitle">Añadir inventario al catálogo</p>
    </header>

    <main class="container form-container">
        <?php if ($mensaje): ?>
            <div style="background: rgba(255, 0, 85, 0.2); border: 1px solid #ff0055; padding: 15px; border-radius: 10px; margin-bottom: 20px; color: #ff0055;">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="nuevo.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Componente</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej. Tarjeta Gráfica GTX 1660">
            </div>

            <div class="form-group">
                <label for="id_marca">Marca</label>
                <select id="id_marca" name="id_marca" required>
                    <option value="">-- Selecciona una Marca --</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>">
                            <?php echo htmlspecialchars($marca['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="precio">Precio ($)</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="stock">Stock Disponible</label>
                <input type="number" id="stock" name="stock" min="0" required placeholder="0">
            </div>

            <button type="submit" class="btn btn-primary">Registrar Componente</button>
            <a href="index.php" class="btn btn-outline" style="text-align: center; display: block; margin-top: 15px;">Cancelar</a>
        </form>
    </main>

</body>
</html>
