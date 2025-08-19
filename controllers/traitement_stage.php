<?php
session_start();
include '../config.php'; // Inclure le fichier de configuration pour la connexion à la base de données

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si non connecté
    exit();
}

// Vérifiez si l'ID de l'étudiant est dans la session
if (!isset($_SESSION['id'])) {
    die("Erreur : L'identifiant de l'étudiant n'est pas disponible.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Démarrer un stage
        if ($action === 'demarrer_stage') {
            // Récupération des données du formulaire
            $nom_entreprise = $_POST['nom_entreprise'];
            $lieu_stage = $_POST['lieu_stage'];
            $adresse_entreprise = $_POST['adresse_entreprise'];
            $nom_encadreur = $_POST['nom_encadreur'];
            $poste_encadreur = $_POST['poste_encadreur'];
            $email_encadreur = $_POST['email_encadreur'];
            $telephone_encadreur = $_POST['telephone_encadreur'];
            $poste_stage = $_POST['poste_stage'];

            try {
                // Insertion des données dans la table stages
                $stmt = $pdo->prepare("INSERT INTO stages (etudiant_id, nom_entreprise, lieu_stage, adresse_entreprise, nom_encadreur, poste_encadreur, email_encadreur, telephone_encadreur, poste_stage) VALUES (:etudiant_id, :nom_entreprise, :lieu_stage, :adresse_entreprise, :nom_encadreur, :poste_encadreur, :email_encadreur, :telephone_encadreur, :poste_stage)");

                $stmt->execute([
                    ':etudiant_id' => $_SESSION['id'], // Assurez-vous que l'ID est bien défini
                    ':nom_entreprise' => $nom_entreprise,
                    ':lieu_stage' => $lieu_stage,
                    ':adresse_entreprise' => $adresse_entreprise,
                    ':nom_encadreur' => $nom_encadreur,
                    ':poste_encadreur' => $poste_encadreur,
                    ':email_encadreur' => $email_encadreur,
                    ':telephone_encadreur' => $telephone_encadreur,
                    ':poste_stage' => $poste_stage
                ]);

                header("Location: ../views/mon_stage.php?message=Stage démarré avec succès!"); // Rediriger vers "Mon Stage"
                exit();

            } catch (PDOException $e) {
                // Gérer les erreurs d'insertion
                header("Location: ../views/mon_stage.php?error=Erreur lors du démarrage du stage: " . $e->getMessage());
                exit();
            }
        }

        // Arrêter le stage
        if ($action === 'arreter_stage') {
            try {
                $stmt = $pdo->prepare("DELETE FROM stages WHERE etudiant_id = :etudiant_id");
                $stmt->execute([':etudiant_id' => $_SESSION['id']]);
                header("Location: ../views/mon_stage.php?message=Stage arrêté avec succès!"); // Rediriger vers "Mon Stage"
                exit();
            } catch (PDOException $e) {
                // Gérer les erreurs de suppression
                header("Location: ../views/mon_stage.php?error=Erreur lors de l'arrêt du stage: " . $e->getMessage());
                exit();
            }
        }

        // Modifier les informations de stage
        if ($action === 'modifier_stage') {
            try {
                $stmt = $pdo->prepare("UPDATE stages SET nom_entreprise = :nom_entreprise, lieu_stage = :lieu_stage, adresse_entreprise = :adresse_entreprise, nom_encadreur = :nom_encadreur, poste_encadreur = :poste_encadreur, email_encadreur = :email_encadreur, telephone_encadreur = :telephone_encadreur, poste_stage = :poste_stage WHERE etudiant_id = :etudiant_id");

                $stmt->execute([
                    ':nom_entreprise' => $_POST['nom_entreprise'],
                    ':lieu_stage' => $_POST['lieu_stage'],
                    ':adresse_entreprise' => $_POST['adresse_entreprise'],
                    ':nom_encadreur' => $_POST['nom_encadreur'],
                    ':poste_encadreur' => $_POST['poste_encadreur'],
                    ':email_encadreur' => $_POST['email_encadreur'],
                    ':telephone_encadreur' => $_POST['telephone_encadreur'],
                    ':poste_stage' => $_POST['poste_stage'],
                    ':etudiant_id' => $_SESSION['id'] // Assurez-vous que l'ID est bien défini
                ]);

                header("Location: ../views/mon_stage.php?message=Informations du stage modifiées avec succès!"); // Rediriger vers "Mon Stage"
                exit();
            } catch (PDOException $e) {
                // Gérer les erreurs de mise à jour
                header("Location: ../views/mon_stage.php?error=Erreur lors de la modification du stage: " . $e->getMessage());
                exit();
            }
        }
    }
}


// Si aucune action POST, afficher la vue mon_stage.php avec les données nécessaires
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Récupérer les demandes acceptées pour l'étudiant connecté
    $demandes_acceptees = [];
    if (isset($_SESSION['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM demandes_stage WHERE etudiant_id = ? AND statut = 'accepté'");
        $stmt->execute([$_SESSION['id']]);
        $demandes_acceptees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sélection de la demande (par défaut la première si aucune sélection)
    $demande_id_selectionnee = isset($_GET['demande_id']) ? intval($_GET['demande_id']) : (isset($demandes_acceptees[0]['id']) ? $demandes_acceptees[0]['id'] : null);
    $nom_entreprise_selectionnee = '';
    if ($demande_id_selectionnee) {
        foreach ($demandes_acceptees as $demande) {
            if ($demande['id'] == $demande_id_selectionnee) {
                $nom_entreprise_selectionnee = $demande['entreprise_nom'];
                break;
            }
        }
    }

    // Récupérer les tâches du carnet de stage liées à la demande sélectionnée
    $carnet_taches = [];
    if ($demande_id_selectionnee) {
        $stmt = $pdo->prepare("SELECT * FROM carnet_stage WHERE etudiant_id = ? AND demande_id = ?");
        $stmt->execute([$_SESSION['id'], $demande_id_selectionnee]);
        $carnet_taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les stages en cours
    $stages = [];
    $stmt = $pdo->prepare("SELECT * FROM stages WHERE etudiant_id = ? AND statut = 'en cours'");
    $stmt->execute([$_SESSION['id']]);
    $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Récupérer les demandes acceptées comme "stages" en cours
    $stages = $demandes_acceptees;

    include '../views/mon_stage.php';
    exit();
}

// Accepter un stage
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'accepter_stage') {
    $demande_id = $_POST['demande_id'];

    try {
        // Mettre à jour le statut du stage
        $stmt = $pdo->prepare("UPDATE stage SET statut = 'accepté' WHERE id = :id");
        $stmt->execute([':id' => $demande_id]);

        // Rediriger ou afficher un message de succès
        header("Location: voir_stages.php?message=Stage accepté avec succès!");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de mise à jour
        header("Location: voir_stages.php?error=Erreur lors de l'acceptation du stage: " . $e->getMessage());
        exit();
    }
}

// Refuser un stage
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'refuser_stage') {
    $demande_id = $_POST['demande_id'];

    try {
        // Mettre à jour le statut du stage
        $stmt = $pdo->prepare("UPDATE stage SET statut = 'refusé' WHERE id = :id");
        $stmt->execute([':id' => $demande_id]);

        // Récupérer l'email de l'étudiant
        $stmt = $pdo->prepare("SELECT email FROM utilisateurs WHERE id = (SELECT etudiant_id FROM demandes_stage WHERE id = :demande_id)");
        $stmt->execute([':demande_id' => $demande_id]);
        $etudiant = $stmt->fetch();

        // Envoyer un email à l'étudiant
        if ($etudiant) {
            $to = $etudiant['email'];
            $subject = "Votre stage a été refusé";
            $message = "Nous vous informons que votre demande de stage a été refusée.";
            // Envoi de l'e-mail (à activer en production)
            // mail($to, $subject, $message);
        }

        // Rediriger ou afficher un message de succès
        header("Location: ../views/voir_stages.php?message=Stage refusé avec succès!");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de mise à jour
        header("Location: ../views/voir_stages.php?error=Erreur lors du refus du stage: " . $e->getMessage());
        exit();
    }
}
?>