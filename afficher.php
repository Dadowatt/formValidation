<?php
require "config.php";
include "framework.php";

// 🛡️ Récupération sécurisée de l'ID dans l'URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// ⚠️ Vérification si l'ID est bien valide
if (!$id) {
    echo "ID non valide.";
    exit;
}

// 📦 Requête pour récupérer l'utilisateur
$sql = "SELECT * FROM users WHERE id = ?";
$query = $conn->prepare($sql);
$query->execute([$id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// ⚠️ Si aucun utilisateur trouvé
if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Utilisateur #<?= htmlspecialchars($user['id']) ?>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($user['nom']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($user['email']) ?></p>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
</body>
</html>
