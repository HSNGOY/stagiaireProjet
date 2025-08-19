<?php
session_start();
require_once '../config.php';
require_once 'EtudiantController.php';
require_once 'DemandeStageController.php';

// Instanciation des contrôleurs
$demandeStageController = new DemandeStageController($pdo);
$etudiantController = new EtudiantController($pdo, $demandeStageController);

// Traitement du formulaire
$etudiantController->traiterFormulaire();
?>