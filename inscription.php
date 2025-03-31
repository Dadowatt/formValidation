<?php
session_start();
require "config.php";
include "framework.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $emailExist = "SELECT id FROM users WHERE email = ?";
  $requete = $conn->prepare($emailExist);
  $requete->execute([$email]);

  if($requete->rowCount() > 0){
    $_SESSION['error'] = "cet email existe déjà";
    header('Location: inscription.php');
    exit();
  }else{
    $requete = "INSERT INTO users (nom, email, password) VALUES (?, ?, ?)";
    $query = $conn->prepare($requete);
    $query->execute([
      $nom, $email, $password
    ]);
    $_SESSION['message'] = "inscription réussie! connectez-vous";
    header('Location: connexion.php');
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
<div class="container mt-5">
  <?php
  if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
  }
  ?>

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