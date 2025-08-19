<?php
session_start();
include '../config.php';

// Vérifiez si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    switch ($action) {
        case 'ajouter_tache':
            // Récupérer les données du formulaire
            $etudiant_id = $_SESSION['id']; // Utilisez l'ID de l'étudiant de la session
            $travail_du_jour = trim($_POST['travail_du_jour']);
            $but = trim($_POST['but']);
            $materiel = trim($_POST['materiel']);
            $temps_prevu = $_POST['temps_prevu'];
            $mode_operatoire = trim($_POST['mode_operatoire']);
            $demande_id = isset($_POST['demande_id']) ? intval($_POST['demande_id']) : null;

            // Valider que les champs requis ne sont pas vides
            if (!empty($travail_du_jour) && !empty($but) && !empty($materiel) && !empty($temps_prevu) && !empty($mode_operatoire) && !empty($demande_id)) {
                try {
                    // Préparer la requête d'insertion

                    $stmt = $pdo->prepare("INSERT INTO carnet_stage (etudiant_id, demande_id, travail_du_jour, but, materiel, temps_prevu, mode_operatoire, date) VALUES (:etudiant_id, :demande_id, :travail_du_jour, :but, :materiel, :temps_prevu, :mode_operatoire, NOW())");

                    // Exécuter la requête avec les données du formulaire
                    $stmt->execute([
                        ':etudiant_id' => $etudiant_id,
                        ':demande_id' => $demande_id,
                        ':travail_du_jour' => $travail_du_jour,
                        ':but' => $but,
                        ':materiel' => $materiel,
                        ':temps_prevu' => $temps_prevu,
                        ':mode_operatoire' => $mode_operatoire
                    ]);

                    // Rediriger vers une page de succès
                    header("Location: ../views/mon_stage.php?message=Tâche ajoutée avec succès !");
                    exit();
                } catch (PDOException $e) {
                    // Afficher l'erreur SQL directement sur la page pour debug
                    echo '<h3 style="color:red;">Erreur SQL : ' . htmlspecialchars($e->getMessage()) . '</h3>';
                    echo '<pre>'; print_r($e->getTraceAsString()); echo '</pre>';
                    exit();
                }
            } else {
                // Rediriger avec un message d'erreur si un champ est vide
                header("Location: ../views/mon_stage.php?error=Tous les champs sont requis.");
                exit();
            }
            break;

        case 'valider_tache':
            // Récupérer les données du formulaire
            $tache_id = $_POST['tache_id'];
            $remarque_encadreur = trim($_POST['remarque_encadreur']);
            $cote_tache = $_POST['cote_tache'];

            // Déterminer si le visa de l'encadreur doit être accordé
            $visa_encadreur = !empty($cote_tache) ? 1 : 0;

            try {
                // Préparer la requête de mise à jour
                $stmt = $pdo->prepare("UPDATE carnet_stage SET remarque_encadreur = :remarque_encadreur, cote_tache = :cote_tache, visa_encadreur = :visa_encadreur WHERE id = :tache_id");

                // Exécuter la requête avec les données du formulaire
                $stmt->execute([
                    ':remarque_encadreur' => $remarque_encadreur,
                    ':cote_tache' => $cote_tache,
                    ':visa_encadreur' => $visa_encadreur,
                    ':tache_id' => $tache_id
                ]);

                // Rediriger vers une page de succès
                header("Location: ../views/mon_stage.php?message=Tâche validée avec succès !");
                exit();
            } catch (PDOException $e) {
                // Afficher l'erreur SQL
                header("Location: ../views/mon_stage.php?error=Erreur de base de données : " . $e->getMessage());
                exit();
            }
            break;

        default:
            // Rediriger si l'action est inconnue
            header("Location: ../views/mon_stage.php?error=Action inconnue.");
            exit();
    }
} else {
    // Rediriger si l'accès à ce fichier est incorrect
    header("Location: ../views/mon_stage.php");
    exit();
}
?>