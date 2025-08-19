<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Stage</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
    <link rel="stylesheet" href="../assets/css/styleEtudiant.css">
    
</head>
<body>
    <header>
        <h1>Demande de Stage</h1>
    </header>
    <main>
        <nav>
            <a href="../controllers/DemandeStageController.php">Retour</a> |
            <a href="../controllers/traitement_stage.php">Mon Stage</a> |
            
        </nav>

        <h2>Vos Demandes de Stage</h2>
        <ul>
            <?php foreach ($demandes as $demande): ?>
                <li>
                    <?php echo htmlspecialchars($demande['entreprise_nom']); ?> - <?php echo htmlspecialchars($demande['entreprise_lieu']); ?>
                    <span class="statut <?php echo htmlspecialchars($demande['statut']); ?>">
                        [<?php echo htmlspecialchars($demande['statut_libelle']); ?>]
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($confirmation_message): ?>
            <div class="confirmation-message"><?php echo htmlspecialchars($confirmation_message); ?></div>
        <?php endif; ?>

        <h2>Faire une Nouvelle Demande</h2>
        <form action="../controllers/DemandeStageController.php" method="POST">
            <label for="entreprise_nom">Nom de l'Entreprise :</label>
            <input type="text" id="entreprise_nom" name="entreprise_nom" required>

            <label for="entreprise_lieu">Lieu :</label>
            <input type="text" id="entreprise_lieu" name="entreprise_lieu" required>

            <label for="entreprise_adresse">Adresse :</label>
            <input type="text" id="entreprise_adresse" name="entreprise_adresse" required>

            <label for="destinateur">Destinateur :</label>
            <input type="text" id="destinateur" name="destinateur" value="Directeur des Ressources Humaines" readonly>

            <div>
                <input type="checkbox" id="confirmation_notice" name="confirmation_notice" required>
                <label for="confirmation_notice">J'accepte que ces informations sont sous ma responsabilité.</label>
            </div>

            <button type="submit">Soumettre la Demande</button>
        </form>
    </main>
   <footer>
    <p>
        &copy; 2025 Universite Don Bosco de Lubumbashi. faire la difference.
        <br>
        République Démocratique du Congo (RDC)<br>
        05, av femmes katangaises/ commune de lubumbashi<br>
        +(243) 822 267 442<br>
        <a href="mailto:infos@udbl.ac.cd">infos@udbl.ac.cd</a><br>
        <a href="https://www.udbl.ac.cd">www.udbl.ac.cd</a>
    </p>
</footer>
</body>
</html>