<?php
session_start();
require 'config.php'; // Connexion à la base de données
include "framework.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Vérifier si l'email existe déjà
    $checkEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        header("Location: inscription.php"); // Redirige vers l'inscription
        exit();
    }

    // ✅ Insérer le nouvel utilisateur si l'email n'existe pas
    $requete = "INSERT INTO users (nom, email, password) VALUES (?, ?, ?)";
    $query = $conn->prepare($requete);
    $query->execute([$nom, $email, $password]);

    // ✅ Ajouter un message de succès
    $_SESSION['message'] = "Inscription réussie ! Connectez-vous maintenant.";
    
    // ✅ Rediriger vers connexion.php
    header("Location: connexion.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post" class="form-control w-50 p-4 mx-auto mt-4 bg-primary-subtle">
        <h3 class="text-center">Inscription</h3>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary fw-bold">S'inscrire</button>
        </div>
    </form>
</div>
</body>
</html>