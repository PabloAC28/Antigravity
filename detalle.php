<?php
require_once 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

$query = "
    SELECT c.id, c.nombre, c.precio, c.stock, m.nombre as marca
    FROM componentes c
    INNER JOIN marcas m ON c.id_marca = m.id_marca
    WHERE c.id = :id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$comp = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comp) {
    header("Location: index.php");
    exit;
}

$dot_class = 'in-stock';
if ($comp['stock'] == 0) $dot_class = 'no-stock';
elseif ($comp['stock'] <= 5) $dot_class = 'low-stock';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle: <?php echo htmlspecialchars($comp['nombre']); ?> | Nexus Hardware</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .detail-card {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            text-align: center;
        }
        .detail-card .price {
            font-size: 2.5rem;
            color: var(--neon-cyan);
            font-weight: 900;
        }
        .detail-card .badge-container {
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detalle de Registro</h1>
        <p class="subtitle">Información detallada del componente</p>
    </header>

    <main class="container form-container">
        <div class="detail-card">
            <h2 style="font-size: 2rem;"><?php echo htmlspecialchars($comp['nombre']); ?></h2>
            <div class="badge-container">
                <span class="brand-badge" style="font-size: 1rem; padding: 6px 16px;"><?php echo htmlspecialchars($comp['marca']); ?></span>
            </div>
            
            <div class="price">$<?php echo number_format($comp['precio'], 2); ?></div>

            <div class="stock-indicator" style="font-size: 1.2rem; margin: 15px 0;">
                <div class="dot <?php echo $dot_class; ?>" style="width: 12px; height: 12px;"></div>
                <span><?php echo $comp['stock']; ?> unidades disponibles en almacén</span>
            </div>
            
            <p style="color: var(--text-muted); font-size: 0.9rem;">ID del registro: #<?php echo str_pad($comp['id'], 3, '0', STR_PAD_LEFT); ?></p>

            <a href="index.php" class="btn btn-outline" style="margin-top: 30px; width: 100%;">Volver al catálogo</a>
        </div>
    </main>

</body>
</html>
