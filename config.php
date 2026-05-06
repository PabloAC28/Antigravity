<?php
// config.php
$db_file = __DIR__ . '/database.sqlite';
$is_new_db = !file_exists($db_file);

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la base de datos es nueva, creamos las tablas y agregamos datos iniciales
    if ($is_new_db) {
        $query = "
            CREATE TABLE IF NOT EXISTS marcas (
                id_marca INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS componentes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                precio REAL NOT NULL,
                stock INTEGER NOT NULL,
                id_marca INTEGER NOT NULL,
                FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
            );
        ";
        $pdo->exec($query);

        // Insertar marcas por defecto
        $marcas_iniciales = ['Asus', 'MSI', 'Corsair', 'Gigabyte', 'EVGA'];
        $stmt = $pdo->prepare("INSERT INTO marcas (nombre) VALUES (:nombre)");
        foreach ($marcas_iniciales as $marca) {
            $stmt->execute([':nombre' => $marca]);
        }

        // Insertar algunos componentes de prueba
        $componentes_iniciales = [
            ['nombre' => 'RTX 4090', 'precio' => 1599.99, 'stock' => 5, 'id_marca' => 2],
            ['nombre' => 'ROG Strix B650', 'precio' => 219.50, 'stock' => 12, 'id_marca' => 1],
            ['nombre' => 'Vengeance RGB 32GB', 'precio' => 110.00, 'stock' => 30, 'id_marca' => 3],
        ];
        
        $stmt_comp = $pdo->prepare("INSERT INTO componentes (nombre, precio, stock, id_marca) VALUES (:nombre, :precio, :stock, :id_marca)");
        foreach ($componentes_iniciales as $comp) {
            $stmt_comp->execute($comp);
        }
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
