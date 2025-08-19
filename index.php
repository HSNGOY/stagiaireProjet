
<?php
// Routeur principal
session_start();

//echo '<div style="background: #ffe; color: #333; padding: 10px; border: 1px solid #ccc;">URL demandée : ' . htmlspecialchars($_GET['url'] ?? 'accueil') . '</div>';
error_log('URL demandée : ' . ($_GET['url'] ?? 'accueil'));
$url = $_GET['url'] ?? 'accueil';

switch ($url) {
    case 'accueil':
        require __DIR__ . '/controllers/AccueilController.php';
        break;
    
    case 'dashboard':
        require __DIR__ . '/controllers/DashboardController.php';
        break;
    case 'admin_dashboard':
        require __DIR__ . '/controllers/AdminController.php';
        break;
    case 'offres':
        require __DIR__ . '/controllers/OffresController.php';
        break;
    case 'demandes':
        require __DIR__ . '/controllers/DemandesController.php';
        break;
    case 'etudiants':
        require __DIR__ . '/controllers/EtudiantsController.php';
        break;
    case 'encadreurs':
        require __DIR__ . '/controllers/traitement_encadreur.php';
        break;
    case 'statistiques':
        require __DIR__ . '/controllers/StatistiquesController.php';
        break;
    case 'consultation_taches':
        require __DIR__ . '/views/consultation_taches.php';
        break;
    case 'parametres':
        require __DIR__ . '/controllers/ParametresController.php';
        break;
    case 'en savoir plus':
        require __DIR__ . '/views/en_savoir_plus.php';
        break;
    case 'infos_etudiant':
        require __DIR__ . '/controllers/InfosEtudiantController.php';
        break;
    case 'mon_stage':
        require __DIR__ . '/controllers/MonStageController.php';
        break;
    case 'demandeStage':
        require __DIR__ . '/controllers/DemandeStageController.php';
        break;
    case 'login':
        require __DIR__ . '/controllers/login.php';
        break;
    case 'vue_encadreur':
        require __DIR__ . '/controllers/traitement_encadreur.php';
        break;
    case 'offres_stage':
        require __DIR__ . '/controllers/OffresController.php';
        break;
    default:
        http_response_code(404);
        echo "Page non trouvée";
}