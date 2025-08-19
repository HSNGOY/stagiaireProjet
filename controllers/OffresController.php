<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
// controllers/OffresController.php
require_once(__DIR__ . '/../config.php'); // Connexion PDO
$message = '';
// Gestion de la création d'une offre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entreprise_nom'])) {
    $nom = $_POST['entreprise_nom'];
    $lieu = $_POST['entreprise_lieu'];
    $adresse = $_POST['entreprise_adresse'];
    $description = $_POST['description'];
    $date_limite = $_POST['date_limite'];
    $stmt = $pdo->prepare("INSERT INTO offres_stage (entreprise_nom, entreprise_lieu, entreprise_adresse, description, date_limite) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $lieu, $adresse, $description, $date_limite])) {
        $message = 'Offre créée avec succès.';
    } else {
        $message = 'Erreur lors de la création de l\'offre.';
    }
}
// Récupérer les offres
$query = "SELECT * FROM offres_stage";
$stmt = $pdo->prepare($query);
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Récupérer les inscriptions
$inscriptions = [];
$inscQuery = "SELECT e.nom AS nom_etudiant, o.entreprise_nom FROM inscriptions i JOIN etudiants e ON i.etudiant_id = e.id JOIN offres_stage o ON i.offre_id = o.id";
$inscStmt = $pdo->prepare($inscQuery);
if ($inscStmt->execute()) {
    $inscriptions = $inscStmt->fetchAll(PDO::FETCH_ASSOC);
}
// Inclure la vue
include(__DIR__ . '/../views/offres.php');
