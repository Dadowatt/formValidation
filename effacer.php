<?php
require "config.php";
include "framework.php";

// ✅ Récupérer l'ID en sécurité
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "ID invalide.";
    exit;
}

// ✅ Vérifier si l'utilisateur existe
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}

// ✅ Suppression de l'utilisateur
$delete = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($delete);
$stmt->execute([$id]);

// ✅ Redirection
header("Location: index.php");
exit;
