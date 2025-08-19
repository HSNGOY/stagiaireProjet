<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt de Rapport de Stage</title>
    <link rel="stylesheet" href="../assets/css/styleRapport.css">
</head>
<body>


    <main>
        <form action="../controllers/traitement_rapport.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="etudiant_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
            <label for="rapport">Choisissez un fichier PDF :</label>
            <input type="file" id="rapport" name="rapport" accept=".pdf" required>
            <button type="submit">Soumettre</button>
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