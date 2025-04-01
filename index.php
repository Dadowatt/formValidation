<?php
session_start();
require "config.php"; // Connexion à la base de données
include "framework.php"; // Inclure d'autres fichiers nécessaires

// ✅ Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php"); // Redirige si non connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> 
</head>
<body>

<div class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']); ?></div>
        <?php unset($_SESSION['message']); // ✅ Supprimer après affichage ?>
    <?php endif; ?>

    <h1>Bienvenue, <?= isset($_SESSION['user_nom']) ? htmlspecialchars($_SESSION['user_nom']) : "Utilisateur"; ?> 🎉</h1>
    
    <a href="logout.php" class="btn btn-danger">Déconnexion</a>

    <div class="card mt-3" style="width: 18rem;">
        <div class="card-header">
            Featured
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">An item</li>
            <li class="list-group-item">A second item</li>
            <li class="list-group-item">A third item</li>
        </ul>
    </div>
</div>

</body>
</html>
