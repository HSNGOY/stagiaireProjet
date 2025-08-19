<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de Stage</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1>Offres de Stage</h1>
    </header>

    <main>
        <div><?php echo $message ?? ''; ?></div>
        
        <h2>Liste des Offres de Stage</h2>
        <?php foreach ($offres as $offre): ?>
        <div class="offre-card">
            <h3><?php echo htmlspecialchars($offre['entreprise_nom']); ?></h3>
            <p><strong>Lieu :</strong> <?php echo htmlspecialchars($offre['entreprise_lieu']); ?></p>
            <p><strong>Description :</strong> <?php echo htmlspecialchars($offre['description']); ?></p>
            <p class="date-limite"><strong>Date Limite :</strong> <?php echo htmlspecialchars($offre['date_limite']); ?></p>
            <form method="POST">
                <input type="hidden" name="offre_id" value="<?php echo $offre['id']; ?>">
                <button type="submit" name="apply">S'inscrire</button>
            </form>
        </div>
        <?php endforeach; ?>
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