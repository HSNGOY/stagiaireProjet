<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
// controllers/StatistiquesController.php
require_once(__DIR__ . '/../config.php'); // Connexion PDO
function compterEtudiants() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM etudiants");
    return $stmt->fetchColumn();
}
function compterDemandesLetters() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM demandes_stage");
    return $stmt->fetchColumn();
}
function compterInscriptionsOffres() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM inscriptions");
    return $stmt->fetchColumn();
}
function compterStagesEnCours() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM stages WHERE statut = 'en cours'");
    return $stmt->fetchColumn();
}
function compterStagesTermines() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM stages WHERE statut = 'termine'");
    return $stmt->fetchColumn();
}
function compterRapportsDeposes() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM rapport");
    return $stmt->fetchColumn();
}
// Inclure la vue
include(__DIR__ . '/../views/statistiques.php');
