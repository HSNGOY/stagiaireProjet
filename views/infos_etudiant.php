<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infos Étudiant</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1>Informations de l'Étudiant</h1>
        <a href="../index.php?url=etudiants" class="btn-back">Retour à la liste</a>
    </header>
    <main>
        <section>
            <h2>Identité</h2>
            <?php if ($etudiant): ?>
                <ul>
                    <li><strong>Nom :</strong> <?php echo htmlspecialchars($etudiant['nom']); ?></li>
                    <li><strong>Post-nom :</strong> <?php echo htmlspecialchars($etudiant['post_nom']); ?></li>
                    <li><strong>Prénom :</strong> <?php echo htmlspecialchars($etudiant['prenom']); ?></li>
                    <li><strong>Email :</strong> <?php echo htmlspecialchars($etudiant['email']); ?></li>
                    <li><strong>Promotion :</strong> <?php echo htmlspecialchars($etudiant['promotion']); ?></li>
                    <li><strong>Filière :</strong> <?php echo htmlspecialchars($etudiant['filiere']); ?></li>
                </ul>
            <?php endif; ?>
        </section>
        <section>
            <h2>Lettres de demande de stage</h2>
            <?php if (!empty($demandes)): ?>
                <ul>
                    <?php foreach ($demandes as $demande): ?>
                        <li><?php echo htmlspecialchars($demande['entreprise_nom'] ?? '') . ' - ' . htmlspecialchars($demande['statut'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune demande trouvée.</p>
            <?php endif; ?>
        </section>
        <section>
            <h2>Inscriptions aux offres de stage</h2>
            <?php if (!empty($offres)): ?>
                <ul>
                    <?php foreach ($offres as $offre): ?>
                        <li><?php echo htmlspecialchars($offre['entreprise_nom'] ?? '') . ' - ' . htmlspecialchars($offre['description'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune inscription trouvée.</p>
            <?php endif; ?>
        </section>
        <section>
            <h2>Stages effectués</h2>
            <?php if (!empty($stages)): ?>
                <ul>
                    <?php foreach ($stages as $stage): ?>
                        <li><?php echo htmlspecialchars($stage['nom_entreprise'] ?? '') . ' - ' . htmlspecialchars($stage['poste_stage'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun stage trouvé.</p>
            <?php endif; ?>
        </section>
        <section>
            <h2>Carnet de stage</h2>
            <?php if (!empty($carnet)): ?>
                <ul>
                    <?php foreach ($carnet as $tache): ?>
                        <li><?php echo htmlspecialchars($tache['travail_du_jour'] ?? '') . ' - ' . htmlspecialchars($tache['date'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune tâche trouvée.</p>
            <?php endif; ?>
        </section>
        <section>
            <h2>Entreprise du stage</h2>
            <?php if ($entreprise): ?>
                <ul>
                    <li><strong>Nom :</strong> <?php echo htmlspecialchars($entreprise['nom'] ?? ''); ?></li>
                    <li><strong>Adresse :</strong> <?php echo htmlspecialchars($entreprise['adresse'] ?? ''); ?></li>
                </ul>
            <?php else: ?>
                <p>Aucune entreprise trouvée.</p>
            <?php endif; ?>
        </section>
        <section>
            <h2>Encadreur</h2>
            <?php if ($encadreur): ?>
                <ul>
                    <li><strong>Nom :</strong> <?php echo htmlspecialchars($encadreur['nom'] ?? ''); ?></li>
                    <li><strong>Email :</strong> <?php echo htmlspecialchars($encadreur['email'] ?? ''); ?></li>
                </ul>
            <?php else: ?>
                <p>Aucun encadreur trouvé.</p>
            <?php endif; ?>
        </section>
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
