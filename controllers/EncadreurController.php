<?php

// Assurez-vous que la session est démarrée (si ce n'est pas déjà fait)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// EncadreurController.php

// Inclure le fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config.php'; // Ajustez le chemin si nécessaire

class EncadreurController {

    private $db; // Stocke l'objet PDO

    public function __construct() {
        global $pdo; // Accéder à l'objet PDO global

        if (!$pdo) {
            throw new Exception("La connexion à la base de données n'a pas été initialisée.");
        }

        $this->db = $pdo; // Assigner l'objet PDO à la propriété $db
    }

    public function afficherTaches() {
        // 1. Vérifier si l'utilisateur est connecté (ID dans la session)
        if (!isset($_SESSION['id'])) {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
            $_SESSION['erreur'] = "Vous devez être connecté pour accéder à cette page.";
            header('Location: index.php?url=login');
            exit();
        }

        // 2. Récupérer l'ID de l'encadreur depuis la session
        if (isset($_SESSION['id']) && $_SESSION['role'] == 'tuteur') {
            $encadreurId = $_SESSION['id'];
        } else {
            // Gérer le cas où l'ID de l'encadreur n'est pas défini dans la session ou l'utilisateur n'est pas un tuteur
            $_SESSION['erreur'] = "ID de l'encadreur non trouvé ou rôle incorrect. Veuillez vous reconnecter.";
            header('Location: index.php?url=login');
            exit();
        }

        // 3. Récupérer l'ID de l'étudiant à partir de la table carnet_stage (vous devrez peut-être adapter votre logique)
        try {
            $stmtEtudiantId = $this->db->prepare("SELECT DISTINCT etudiant_id FROM carnet_stage WHERE encadreur_id = :encadreur_id");
            $stmtEtudiantId->execute([':encadreur_id' => $encadreurId]);
            $etudiantIds = $stmtEtudiantId->fetchAll(PDO::FETCH_COLUMN);

            if (empty($etudiantIds)) {
                $_SESSION['erreur'] = "Aucun étudiant trouvé pour cet encadreur.";
                include 'consultation_taches.php'; // Inclure la vue même en cas d'erreur
                exit();
            }

            // Pour simplifier, on prend le premier étudiant trouvé (à adapter si un encadreur peut avoir plusieurs étudiants)
            $etudiantId = $etudiantIds[0];

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'ID de l'étudiant : " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors de la récupération de l'ID de l'étudiant.";
            include '../views/consultation_taches.php'; // Inclure la vue même en cas d'erreur
            exit();
        }

        // 4. Récupérer les informations de l'étudiant
        try {
            $stmtEtudiant = $this->db->prepare("SELECT nom, prenom FROM etudiants WHERE id = :id");
            $stmtEtudiant->execute([':id' => $etudiantId]);
            $etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);

            // Vérifications importantes :
            var_dump($etudiantId); // Afficher la valeur de $etudiantId
            var_dump($etudiant); // Afficher le contenu du tableau $etudiant

            if (!$etudiant) {
                $_SESSION['erreur'] = "Étudiant non trouvé.";
                $nom_etudiant = "Étudiant non trouvé"; // Valeur par défaut
            } else {
                // Vérifier si les clés 'nom' et 'prenom' existent
                if (isset($etudiant['nom']) && isset($etudiant['prenom'])) {
                    $nom_etudiant = htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']);
                } else {
                    $_SESSION['erreur'] = "Les clés 'nom' et 'prenom' sont manquantes dans le tableau \$etudiant.";
                    $nom_etudiant = "Nom inconnu"; // Valeur par défaut
                }
            }

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des informations de l'étudiant : " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors de la récupération des informations de l'étudiant.";
            $nom_etudiant = "Erreur de base de données"; // Valeur par défaut
        }

        // 5. Récupérer les tâches depuis la base de données
        try {
            $stmt = $this->db->prepare("SELECT * FROM carnet_stage WHERE encadreur_id = :encadreur_id AND etudiant_id = :etudiant_id"); // Adaptez la requête
            $stmt->execute([':encadreur_id' => $encadreurId, ':etudiant_id' => $etudiantId]);
            $taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des tâches : " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors de la récupération des tâches.";
        }

        // 6. Inclure la vue pour afficher les tâches
        include 'consultation_taches.php';
    }

    public function traiterSoumission() {
        // ... (Votre code existant) ...
    }
}

// ==========================================================================
//  Exemple d'utilisation (à adapter à votre framework/structure)
// ==========================================================================

// 1. Instancier le contrôleur (EncadreurController)
$controller = new EncadreurController();

// 2. Gérer les actions en fonction de l'URL
$action = $_GET['action'] ?? 'afficherTaches'; // Action par défaut

switch ($action) {
    case 'afficherTaches':
        $controller->afficherTaches();
        break;
    case 'traiterSoumission':
        $controller->traiterSoumission();
        break;
    default:
        // Gérer l'action inconnue (rediriger ou afficher une erreur)
        echo "Action inconnue.";
        break;
}