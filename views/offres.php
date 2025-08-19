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
        <h1>Admin Manager</h1>
        <a href="/StagiaireGestion-master/index.php?url=accueil" class="btn-home">Accueil</a>
    </header>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/menu.php'; renderMenu('offres'); ?>
        <main>
            <section>
                <h2>Inscriptions aux Offres de Stage</h2>
                <!-- Tableau des inscriptions -->
                <?php if (!empty($inscriptions)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'Étudiant</th>
                            <th>Nom de l'Entreprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscriptions as $inscription): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inscription['nom_etudiant'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($inscription['entreprise_nom'] ?? ''); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>Aucune inscription trouvée.</p>
                <?php endif; ?>

                <h2>Créer une Offre de Stage</h2>
                <form method="POST">
                    <label>Nom de l'Entreprise :</label>
                    <input type="text" name="entreprise_nom" required>
                    <label>Lieu :</label>
                    <input type="text" name="entreprise_lieu" required>
                    <label>Adresse :</label>
                    <input type="text" name="entreprise_adresse" required>
                    <label>Description :</label>
                    <textarea name="description" required></textarea>
                    <label>Date Limite :</label>
                    <input type="date" name="date_limite" required>
                    <button type="submit">Créer l'Offre</button>
                </form>
                <div><?php echo $message ?? ''; ?></div>

                <h2>Offres de Stage</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'Entreprise</th>
                            <th>Lieu</th>
                            <th>Adresse</th>
                            <th>Description</th>
                            <th>Date Limite</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM offres_stage";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($offres as $offre) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($offre['entreprise_nom'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($offre['entreprise_lieu'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($offre['entreprise_adresse'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($offre['description'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($offre['date_limite'] ?? '') . "</td>";
                            echo "<td>
                                    <form method='POST' action='modifier_offre.php'>
                                        <input type='hidden' name='id' value='" . $offre['id'] . "'>
                                        <button type='submit' name='edit_offer'>Modifier</button>
                                    </form>
                                    <form method='POST' action='supprimer_offre.php'>
                                        <input type='hidden' name='id' value='" . $offre['id'] . "'>
                                        <button type='submit' name='delete_offer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette offre ?\");'>Supprimer</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
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
