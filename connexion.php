<?php
session_start();
require 'config.php'; // Connexion à la base de données
include "framework.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $requete = "SELECT * FROM users WHERE email = ?";
    $query = $conn->prepare($requete);
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Stocker l'utilisateur en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['message'] = "Connexion réussie, bienvenue ";

        // ✅ Redirection vers index.php
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect ";
        header("Location: connexion.php");
        exit();
    }
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

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success"><?= $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


        
    <form method="post" class="form-control w-25 p-4 bg-body-secondary mx-auto mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3 text-center">
        <button type="submit" class="btn btn-primary px-3 fw-bold">Login</button>
        </div>
    </form>
</body>
</html>