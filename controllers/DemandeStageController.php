<?php
// DemandeStageController.php
session_start(); // Assurez-vous que la session est démarrée
require_once '../config.php';

class DemandeStageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer les demandes de stage d'un étudiant
    public function afficherDemandes($etudiant_id) {
        $stmt = $this->pdo->prepare("SELECT *, 
            CASE 
                WHEN statut = 'accepté' THEN 'Acceptée'
                WHEN statut = 'refusee' THEN 'Refusée'
                WHEN statut = 'en attente' THEN 'En attente'
                ELSE 'En attente.'
            END as statut_libelle 
            FROM demandes_stage WHERE etudiant_id = ?");
        $stmt->execute([$etudiant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une demande de stage
    public function ajouterDemande($etudiant_id, $entreprise_nom, $entreprise_lieu, $entreprise_adresse, $destinateur, $confirmation_notice) {
        $stmt = $this->pdo->prepare("INSERT INTO demandes_stage (etudiant_id, entreprise_nom, entreprise_lieu, entreprise_adresse, destinateur, confirmation_notice) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt->execute([$etudiant_id, $entreprise_nom, $entreprise_lieu, $entreprise_adresse, $destinateur, $confirmation_notice])) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }

    // Afficher le formulaire des informations de l'entreprise
    public function afficherFormulaireEntreprise($confirmation_message = null, $demandes = []) {
        // Vérifier si l'ID de l'étudiant est défini dans la session
        if (!isset($_SESSION['id'])) {
            // Rediriger vers le formulaire d'authentification si l'utilisateur n'est pas authentifié
            header("Location: EtudiantController.php");
            exit();
        }
        $etudiant_id = $_SESSION['id'];
        // Inclure la vue du formulaire entreprise
        include '../views/demandeStage.php';
    }

    // Point d'entrée pour le contrôleur
    public function gererRequete() {
        // Vérifier si l'utilisateur est authentifié
        if (!isset($_SESSION['id'])) {
            // Rediriger vers le formulaire d'authentification si l'utilisateur n'est pas authentifié
            header("Location: EtudiantController.php");
            exit();
        }

        $etudiant_id = $_SESSION['id'];
        $confirmation_message = null;
        $demandes = $this->afficherDemandes($etudiant_id);

        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $entreprise_nom = $_POST['entreprise_nom'];
            $entreprise_lieu = $_POST['entreprise_lieu'];
            $entreprise_adresse = $_POST['entreprise_adresse'];
            $destinateur = $_POST['destinateur'];
            $confirmation_notice = isset($_POST['confirmation_notice']) ? 1 : 0; // 1 si coché, 0 sinon

            // Appel à la méthode du contrôleur pour ajouter la demande
            $ajout_reussi = $this->ajouterDemande($etudiant_id, $entreprise_nom, $entreprise_lieu, $entreprise_adresse, $destinateur, $confirmation_notice);

            if ($ajout_reussi) {
                // Redirection vers l'index après soumission réussie
                header("Location: ../index.php");
                exit();
            } else {
                $confirmation_message = "Erreur lors de la soumission de votre demande. Veuillez réessayer.";
            }
        }

        // Afficher le formulaire avec le message de confirmation et les demandes
        $this->afficherFormulaireEntreprise($confirmation_message, $demandes);
    }
}

// Instancier le contrôleur et gérer la requête
$demandeStageController = new DemandeStageController($pdo);
$demandeStageController->gererRequete();
?>