<?php
require_once 'auth_check.php';
require_once 'config.php';

// Obtener componentes junto con el nombre de su marca
$query = "
    SELECT c.id, c.nombre, c.precio, c.stock, m.nombre as marca
    FROM componentes c
    INNER JOIN marcas m ON c.id_marca = m.id_marca
    ORDER BY c.id DESC
";
$stmt = $pdo->query($query);
$componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Hardware | Catálogo Premium</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="admin-nav">
        <?php if (is_logged_in()): ?>
            <a href="logout.php">Cerrar Sesión (Admin)</a>
        <?php else: ?>
            <a href="login.php">Acceso Admin</a>
        <?php endif; ?>
    </nav>

    <header>
        <h1>Nexus Hardware</h1>
        <p class="subtitle">Catálogo de componentes de alto rendimiento</p>
    </header>

    <main class="container">
        <?php if (count($componentes) > 0): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Componente</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Disponibilidad</th>
                            <?php if (is_logged_in()): ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($componentes as $comp): ?>
                            <?php 
                                $dot_class = 'in-stock';
                                if ($comp['stock'] == 0) $dot_class = 'no-stock';
                                elseif ($comp['stock'] <= 5) $dot_class = 'low-stock';
                            ?>
                            <tr>
                                <td class="id-col">#<?php echo str_pad($comp['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td class="name-col"><a href="detalle.php?id=<?php echo $comp['id']; ?>" style="color: var(--neon-cyan); text-decoration: none; font-weight: bold; padding-bottom: 2px; border-bottom: 1px solid var(--neon-purple);"><?php echo htmlspecialchars($comp['nombre']); ?></a></td>
                                <td><span class="brand-badge"><?php echo htmlspecialchars($comp['marca']); ?></span></td>
                                <td class="price-col">$<?php echo number_format($comp['precio'], 2); ?></td>
                                <td>
                                    <div class="stock-indicator">
                                        <div class="dot <?php echo $dot_class; ?>"></div>
                                        <span><?php echo $comp['stock']; ?> uds.</span>
                                    </div>
                                </td>
                                <?php if (is_logged_in()): ?>
                                    <td>
                                        <a href="editar.php?id=<?php echo $comp['id']; ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600; margin-right: 10px;">Editar</a>
                                        <form action="eliminar.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este componente?');">
                                            <input type="hidden" name="id" value="<?php echo $comp['id']; ?>">
                                            <button type="submit" style="background: none; border: none; color: #ff0055; cursor: pointer; font-weight: 600; font-family: inherit; font-size: inherit;">Eliminar</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No hay componentes en el catálogo</h2>
                <p>Haz clic en el botón '+' para añadir tu primer producto.</p>
            </div>
        <?php endif; ?>
    </main>

    <?php if (is_logged_in()): ?>
        <a href="nuevo.php" class="fab" title="Añadir nuevo componente">+</a>
    <?php endif; ?>

</body>
</html>

