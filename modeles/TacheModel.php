<?php
// TacheModel.php

class TacheModel {
      private $db;

    public function __construct() {
        // Inclure le fichier de configuration pour obtenir l'objet PDO
        require_once __DIR__ . '/../config.php'; // Ajustez le chemin si nécessaire

        // Utiliser l'objet PDO créé dans config.php
        global $pdo;

        if (!$pdo) {
            throw new Exception("La connexion à la base de données n'a pas été initialisée.");
        }

        $this->db = $pdo;
    }

    public function getTachesParEncadreur($etudiantId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM carnet_stage WHERE etudiant_id = :etudiant_id");
            $stmt->execute([':etudiant_id' => $etudiantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des tâches : " . $e->getMessage());
            return false; // ou lancez une exception
        }
    }

    public function updateTache($carnetId, $remarqueEncadreur, $coteTache, $visaEncadreur) {
        try {
            $stmt = $this->db->prepare("
                UPDATE carnet_stage
                SET remarque_encadreur = :remarque_encadreur,
                    cote_tache = :cote_tache,
                    visa_encadreur = :visa_encadreur
                WHERE id = :carnet_id
            ");

            $stmt->execute([
                ':remarque_encadreur' => $remarqueEncadreur,
                ':cote_tache' => $coteTache,
                ':visa_encadreur' => $visaEncadreur,
                ':carnet_id' => $carnetId
            ]);

            // Vérifiez si la requête a affecté une ligne
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la tâche : " . $e->getMessage());
            return false; // ou lancez une exception
        }
    }
}