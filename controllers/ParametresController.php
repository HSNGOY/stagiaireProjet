<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
// controllers/ParametresController.php
require_once(__DIR__ . '/../config.php'); // Connexion PDO
// Ici, ajoutez la logique de gestion des paramètres si besoin
// Exemple : gestion du mot de passe admin, configuration générale, etc.
// Inclure la vue
include(__DIR__ . '/../views/parametres.php');
