<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si l'ID de l'étudiant est dans la session
    if (!isset($_SESSION['id'])) {
        header("Location: ../controllers/login.php?error=Vous devez être connecté pour enregistrer un encadreur.");
        exit();
    }

    $etudiant_id = intval($_SESSION['id']);

    $nom_encadreur = trim($_POST['nom_encadreur']);
    $poste_encadreur = trim($_POST['poste_encadreur']);
    $email_encadreur = trim($_POST['email_encadreur']);
    $telephone_encadreur = trim($_POST['telephone_encadreur']);

    if (!empty($nom_encadreur) && !empty($poste_encadreur) && !empty($email_encadreur) && !empty($telephone_encadreur)) {

        try {
            // Déterminez si nous devons insérer ou mettre à jour
            if (isset($_POST['action']) && $_POST['action'] == 'modifier') {
                // Mise à jour
                $stmt = $pdo->prepare("UPDATE encadreurs SET nom_encadreur = ?, poste_encadreur = ?, email_encadreur = ?, telephone_encadreur = ? WHERE etudiant_id = ?");
                $stmt->execute([$nom_encadreur, $poste_encadreur, $email_encadreur, $telephone_encadreur, $etudiant_id]);
                $message = "Informations de l'encadreur mises à jour avec succès !";
            } else {
                // Insertion
                // Vérifiez d'abord si un encadreur existe déjà pour cet étudiant
                $stmt = $pdo->prepare("SELECT id FROM encadreurs WHERE etudiant_id = ?");
                $stmt->execute([$etudiant_id]);

                if ($stmt->fetch()) {
                    // Un encadreur existe déjà, affichez une erreur
                    header("Location: ../views/mon_stage.php?error=Un encadreur est déjà enregistré. Veuillez modifier les informations existantes.");
                    exit();
                } else {
                    // Aucun encadreur n'existe, insérez les informations
                    $stmt = $pdo->prepare("INSERT INTO encadreurs (etudiant_id, nom_encadreur, poste_encadreur, email_encadreur, telephone_encadreur) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$etudiant_id, $nom_encadreur, $poste_encadreur, $email_encadreur, $telephone_encadreur]);
                    $message = "Encadreur enregistré avec succès !";
                }
            }

            header("Location: ../views/mon_stage.php?message=" . urlencode($message));
            exit();

        } catch (PDOException $e) {
            echo '<h3 style="color:red;">Erreur SQL : ' . htmlspecialchars($e->getMessage()) . '</h3>';
            exit();
        }
    } else {
        header("Location: ../views/mon_stage.php?error=Tous les champs de l'encadreur sont requis.");
        exit();
    }
} else {
    header("Location: ../views/mon_stage.php");
    exit();
}