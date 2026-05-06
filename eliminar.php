<?php
require_once 'auth_check.php';
require_login();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM componentes WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

header("Location: index.php");
exit;
?>
