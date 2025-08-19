<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
require_once(__DIR__ . '/../config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('Étudiant non trouvé.');
}
// Infos de base
$stmt = $pdo->prepare('SELECT * FROM etudiants WHERE id = ?');
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
// Lettres de demande de stage
$stmt = $pdo->prepare('SELECT * FROM demandes_stage WHERE etudiant_id = ?');
$stmt->execute([$id]);
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Inscriptions aux offres de stage
$stmt = $pdo->prepare('SELECT o.* FROM inscriptions i JOIN offres_stage o ON i.offre_id = o.id WHERE i.etudiant_id = ?');
$stmt->execute([$id]);
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Stages effectués
$stmt = $pdo->prepare('SELECT * FROM stages WHERE etudiant_id = ?');
$stmt->execute([$id]);
$stages = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Carnet de stage
$stmt = $pdo->prepare('SELECT * FROM carnet_stage WHERE etudiant_id = ?');
$stmt->execute([$id]);
$carnet = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Infos entreprise du stage
$stmt = $pdo->prepare('SELECT entreprise_nom, entreprise_adresse FROM demandes_stage WHERE etudiant_id = ? ORDER BY id DESC LIMIT 1');
$stmt->execute([$id]);
$entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
// Infos encadreur
$stmt = $pdo->prepare('SELECT * FROM encadreurs WHERE id = (SELECT id FROM encadreurs WHERE etudiant_id = ? LIMIT 1)');
$stmt->execute([$id]);
$encadreur = $stmt->fetch(PDO::FETCH_ASSOC);
// Inclure la vue
include(__DIR__ . '/../views/infos_etudiant.php');
