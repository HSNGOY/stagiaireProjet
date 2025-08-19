<?php
// EtudiantController.php
session_start();
require_once '../config.php';

// Définition des constantes pour les actions
define('ACTION_LOGIN', 'login');
define('ACTION_REGISTER', 'register');

class EtudiantController {
    private $pdo;
    private $demandeStageController;

    public function __construct($pdo, $demandeStageController = null) {
        $this->pdo = $pdo;
        $this->demandeStageController = $demandeStageController;
    }

    public function setDemandeStageController(DemandeStageController $demandeStageController) {
        $this->demandeStageController = $demandeStageController;
    }

    public function traiterFormulaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                try {
                    switch ($_POST['action']) {
                        case ACTION_LOGIN:
                            $this->authentifierEtudiant($_POST);
                            break;
                        case ACTION_REGISTER:
                            $this->enregistrerEtudiant($_POST);
                            break;
                        default:
                            throw new Exception("Action non reconnue.");
                    }
                } catch (Exception $e) {
                    $error_message = $e->getMessage();
                    include '../views/etudiant_form.php';
                    return;
                }
            } else {
                $error_message = "Aucune action spécifiée.";
                include '../views/etudiant_form.php';
                return;
            }
        }

        // Afficher le formulaire par défaut (avec les options d'authentification et d'enregistrement)
        include '../views/etudiant_form.php';
    }

  public function authentifierEtudiant($data) {
    // Rechercher l'étudiant par email
    $stmt = $this->pdo->prepare("SELECT id, mot_de_passe FROM etudiants WHERE email = ?");
    $stmt->execute([$data['email']]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
        // Vérifier le mot de passe
        if (password_verify($data['mot_de_passe'], $etudiant['mot_de_passe'])) {
            $_SESSION['id'] = $etudiant['id']; // Stocker l'ID dans la session
            $this->redirigerVersDemandeStage();
        } else {
            // Message d'erreur si le mot de passe est incorrect
            throw new Exception("Mot de passe incorrect pour cet email.");
        }
    } else {
        // Message d'erreur si l'email n'est pas trouvé
        throw new Exception("Aucun étudiant trouvé avec cet email.");
    }
}

    public function enregistrerEtudiant($data) {
        // Vérification des données reçues
        if ($data['mot_de_passe'] !== $data['confirmation_mot_de_passe']) {
            throw new Exception("Les mots de passe ne correspondent pas.");
        }

        // Vérifier si l'étudiant existe déjà (par email)
        $stmt = $this->pdo->prepare("SELECT id FROM etudiants WHERE email = ?");
        $stmt->execute([$data['email']]);
        $etudiant_id = $stmt->fetchColumn();

        if ($etudiant_id) {
            throw new Exception("Un étudiant avec cet email existe déjà. Veuillez vous authentifier.");
        }

        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);

        // Ajouter l'étudiant dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO etudiants (matricule, nom, post_nom, prenom, genre, email, promotion, filiere, telephone, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'etudiant')");

        if (!$stmt->execute([
            $data['matricule'],
            $data['nom'],
            $data['post_nom'],
            $data['prenom'],
            $data['genre'],
            $data['email'],
            $data['promotion'],
            $data['filiere'],
            $data['telephone'],
            $mot_de_passe_hache
        ])) {
            throw new Exception("Erreur lors de l'ajout de l'étudiant.");
        }

        $etudiant_id = $this->pdo->lastInsertId();
        $_SESSION['id'] = $etudiant_id;

        $this->redirigerVersDemandeStage();
    }

    private function redirigerVersDemandeStage() {
        // Rediriger vers DemandeStageController
        header("Location: ../controllers/DemandeStageController.php");
        exit();
    }
}

// Instancier le contrôleur et gérer la requête
$etudiantController = new EtudiantController($pdo);
$etudiantController->traiterFormulaire();
?>