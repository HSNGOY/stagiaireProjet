<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1>Admin Manager</h1>
        <a href="/StagiaireGestion-master/index.php?url=accueil" class="btn-home">Accueil</a>
    </header>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/menu.php'; renderMenu('statistiques'); ?>
        <main>
            <section>
                <h2>Statistiques</h2>
                <div class="statistiques">
                    <ul>
                        <li><strong>Nombre d'Étudiants Inscrits :</strong> <?php echo compterEtudiants(); ?></li>
                        <li><strong>Nombre de Demandes de Lettres :</strong> <?php echo compterDemandesLetters(); ?></li>
                        <li><strong>Inscriptions aux Différentes Offres :</strong> <?php echo compterInscriptionsOffres(); ?></li>
                        <li><strong>Stages en Cours :</strong> <?php echo compterStagesEnCours(); ?></li>
                        <li><strong>Stages Terminés :</strong> <?php echo compterStagesTermines(); ?></li>
                        <li><strong>Rapports Déposés :</strong> <?php echo compterRapportsDeposes(); ?></li>
                    </ul>
                </div>
            </section>
        </main>
    </div>
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
