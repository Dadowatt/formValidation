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

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); // Supprimer après affichage ?>
<?php endif; ?>


<form method="post" class="w-75 form-control bg-body-secondary">
  <div class="mb-3">
    <label for="nom" class="form-label">Nom</label>
    <input type="text" class="form-control" name="nom" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
  </div>
  <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>
</div>
</body>
</html>