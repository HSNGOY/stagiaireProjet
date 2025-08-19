<?php
// controllers/EtudiantsController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
require_once(__DIR__ . '/../config.php'); // Connexion PDO
$message = '';
// Gestion de la recherche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = '%' . $_POST['search_term'] . '%';
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE nom LIKE ? OR email LIKE ?");
    $stmt->execute([$search, $search]);
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT * FROM etudiants");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Gestion de l'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $stmt = $pdo->prepare("INSERT INTO etudiants (nom, post_nom, prenom, genre, email, mot_de_passe, promotion, filiere, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $ok = $stmt->execute([
        $_POST['new_nom'], $_POST['new_post_nom'], $_POST['new_prenom'], $_POST['new_genre'], $_POST['new_email'], $_POST['new_mot_de_passe'], $_POST['new_promotion'], $_POST['new_filiere'], $_POST['new_telephone']
    ]);
    $message = $ok ? 'Étudiant ajouté.' : 'Erreur lors de l\'ajout.';
    // Recharger la liste
    $stmt = $pdo->prepare("SELECT * FROM etudiants");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Gestion de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
    $stmt = $pdo->prepare("UPDATE etudiants SET nom=?, post_nom=?, prenom=?, genre=?, email=?, promotion=?, filiere=?, telephone=? WHERE id=?");
    $ok = $stmt->execute([
        $_POST['edit_nom'], $_POST['edit_post_nom'], $_POST['edit_prenom'], $_POST['edit_genre'], $_POST['edit_email'], $_POST['edit_promotion'], $_POST['edit_filiere'], $_POST['edit_telephone'], $_POST['student_id']
    ]);
    $message = $ok ? 'Étudiant modifié.' : 'Erreur lors de la modification.';
    $stmt = $pdo->prepare("SELECT * FROM etudiants");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Gestion de la suppression
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id=?");
    $ok = $stmt->execute([$_GET['delete_id']]);
    $message = $ok ? 'Étudiant supprimé.' : 'Erreur lors de la suppression.';
    $stmt = $pdo->prepare("SELECT * FROM etudiants");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Inclure la vue
include(__DIR__ . '/../views/etudiants.php');
