<?php
// login.php
require_once 'auth_check.php';

if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Credenciales proporcionadas por el usuario
    if ($username === 'palcaide' && $password === 'Java1654') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Nexus Hardware</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-page">

    <header>
        <h1>Acceso Administrador</h1>
        <p class="subtitle">Nexus Hardware Management</p>
    </header>

    <main class="container form-container login-wrapper">
        <?php if ($error): ?>
            <div class="error-box">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required placeholder="Ingresa tu usuario">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="index.php" class="btn btn-outline" style="text-align: center; display: block; margin-top: 15px;">Volver al Catálogo</a>
        </form>
    </main>

</body>
</html>
