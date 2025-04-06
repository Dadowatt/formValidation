<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: connexion.php');
    exit();
}
require "config.php";
include "framework.php";
$sql = "SELECT * FROM users";
$requete = $conn->query($sql);
$users = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Liste des utilisateurs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
  <h2 class="mb-4">Liste des utilisateurs</h2>
  <div class="row">
    <?php foreach ($users as $user): ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header"><?= htmlspecialchars($user['nom']) ?></div>
          <div class="card-body">
            <p>Email : <?= htmlspecialchars($user['email']) ?></p>
            <a href="afficher.php?id=<?= $user['id'] ?>" class="btn btn-info btn-sm">Voir plus</a>
            <a href="modifier.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="effacer.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Es-tu sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
