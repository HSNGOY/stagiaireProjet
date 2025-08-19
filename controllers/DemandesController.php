<?php
// controllers/DemandesController.php
require_once(__DIR__ . '/../config.php'); // Connexion PDO
// Récupérer les demandes de stages avec les infos de l'étudiant
$stmt = $pdo->prepare("SELECT d.*, e.nom, e.post_nom, e.prenom FROM demandes_stage d JOIN etudiants e ON d.etudiant_id = e.id");
$stmt->execute();
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Gestion des actions (accepter, refuser, annuler)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['demande_id'], $_POST['action'])) {
        $id = intval($_POST['demande_id']);
        $action = $_POST['action'];
        if ($action === 'accepter_stage') {
            $pdo->prepare("UPDATE demandes_stage SET statut = 'accepté' WHERE id = ?")->execute([$id]);
        } elseif ($action === 'refuser_stage') {
            $pdo->prepare("UPDATE demandes_stage SET statut = 'refusé' WHERE id = ?")->execute([$id]);
        } elseif ($action === 'annuler') {
            $pdo->prepare("UPDATE demandes_stage SET statut = 'en attente' WHERE id = ?")->execute([$id]);
        }
        // Recharger les données après modification
        $stmt = $pdo->prepare("SELECT d.*, e.nom, e.post_nom, e.prenom FROM demandes_stage d JOIN etudiants e ON d.etudiant_id = e.id");
        $stmt->execute();
        $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
// Inclure la vue
include(__DIR__ . '/../views/demandes.php');
