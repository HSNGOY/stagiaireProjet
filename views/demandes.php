<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Stages</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1>Admin Manager</h1>
        <a href="../index.php?url=accueil" class="btn-home">Accueil</a>
    </header>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/menu.php'; renderMenu('demandes'); ?>
        <main>
            <section>
                <h2>Demandes de Stages</h2>
                <!-- Copiez ici le code PHP/tableau des demandes depuis admin_dashboard.php -->
                <?php
                // $demandes est déjà préparé par le contrôleur
                if (!empty($demandes)):
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Post Nom</th>
                            <th>Prénom</th>
                            <th>Nom de l'Entreprise</th>
                            <th>Lieu de l'Entreprise</th>
                            <th>Adresse de l'Entreprise</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demandes as $demande): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($demande['nom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($demande['post_nom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($demande['prenom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($demande['entreprise_nom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($demande['entreprise_lieu'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($demande['entreprise_adresse'] ?? ''); ?></td>
                            <td id="statut-<?php echo $demande['id']; ?>">
                                <?php echo htmlspecialchars($demande['statut'] ?? ''); ?>
                            </td>
                            <td id="actions-<?php echo $demande['id']; ?>">
                                <?php if ($demande['statut'] === 'en attente'): ?>
                                    <button type="button" onclick="changeStatus('accepter', <?php echo $demande['id']; ?>)">Accepter</button>
                                    <button type="button" onclick="changeStatus('refuser', <?php echo $demande['id']; ?>)">Refuser</button>
                                <?php else: ?>
                                    <span><?php echo htmlspecialchars($demande['statut']); ?></span>
                                    <button type="button" onclick="cancelAction(<?php echo $demande['id']; ?>)">Annuler</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>Aucune demande de stage enregistrée.</p>
                <?php endif; ?>
                <script>
                function changeStatus(action, id) {
                    const statusText = document.getElementById('statut-' + id);
                    const actionsDiv = document.getElementById('actions-' + id);
                    if (action === 'accepter') {
                        statusText.textContent = 'accepté';
                    } else {
                        statusText.textContent = 'refusé';
                    }
                    fetch('../controllers/AdminController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'demande_id=' + encodeURIComponent(id) + '&action=' + encodeURIComponent(action === 'accepter' ? 'accepter_stage' : 'refuser_stage')
                    })
                    .then(response => response.text())
                    .then(data => {})
                    .catch(error => {
                        alert('Erreur lors de la mise à jour du statut.');
                    });
                }
                function cancelAction(id) {
                    const statusText = document.getElementById('statut-' + id);
                    const actionsDiv = document.getElementById('actions-' + id);
                    statusText.textContent = 'en attente';
                    actionsDiv.innerHTML = `
                        <button type="button" onclick="changeStatus('accepter', ${id})">Accepter</button>
                        <button type="button" onclick="changeStatus('refuser', ${id})">Refuser</button>
                    `;
                }
                </script>
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
