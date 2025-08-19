<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
    <style>
        .content-section { display: none; }
        .content-section.active { display: block; }
    </style>
    <script>
        function showSection(section) {
            // Cacher toutes les sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(s => s.classList.remove('active'));

            // Afficher la section sélectionnée
            const target = document.getElementById(section);
            if (target) target.classList.add('active');

            // Mettre à jour le menu actif
            const links = document.querySelectorAll('nav ul li a');
            links.forEach(link => link.classList.remove('active'));
            const activeLink = Array.from(links).find(link => link.getAttribute('onclick') && link.getAttribute('onclick').includes(section));
            if (activeLink) activeLink.classList.add('active');
        }

        // Afficher la section par défaut au chargement et le menu actif
        window.onload = function() {
            showSection('dashboardSection');
        }
    </script>
</head>
<body>
    <header>
        <h1>Admin Manager</h1>
    </header>

    <div class="dashboard-layout">
        <nav>
            <ul>
                <li><a href="javascript:void(0);" onclick="showSection('dashboardSection')" class="active">dashboard</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('offresSection')">Offres de stage</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('lettreSection')">demandes de lettres</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('etudiantsSection')">Etudiants</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('statistiquesSection')">Statistiques</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('parametresSection')">Paramètres</a></li>
            </ul>
        </nav>
        <main>
        <!-- Section Tableau de Bord -->
        <section id="dashboardSection" class="content-section">
            <h2>Tableau de Bord</h2>
            <p>Bienvenue dans le tableau de bord de l'administrateur.</p>
        </section>

        <!-- Section Demandes de Stages -->
        <section id="lettreSection" class="content-section active">
<h2>Demandes de Stages</h2>
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
        <?php
        // $demandes est déjà préparé par le contrôleur
        if (!empty($demandes)): ?>
            <?php foreach ($demandes as $demande): ?>
                <tr>
                    <td><?php echo htmlspecialchars($demande['nom']); ?></td>
                    <td><?php echo htmlspecialchars($demande['post_nom']); ?></td>
                    <td><?php echo htmlspecialchars($demande['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($demande['entreprise_nom']); ?></td>
                    <td><?php echo htmlspecialchars($demande['entreprise_lieu']); ?></td>
                    <td><?php echo htmlspecialchars($demande['entreprise_adresse']); ?></td>
                    <td id="statut-<?php echo $demande['id']; ?>">
                        <?php echo htmlspecialchars($demande['statut']); ?>
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
        <?php else: ?>
            <tr>
                <td colspan="8">Aucune demande de stage enregistrée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>

function changeStatus(action, id) {
    const statusText = document.getElementById('statut-' + id);
    const actionsDiv = document.getElementById('actions-' + id);

    // Mettre à jour le texte du statut et masquer les boutons
    if (action === 'accepter') {
        statusText.textContent = 'accepté';
    } else {
        statusText.textContent = 'refusé';
    }

    // Requête AJAX vers le contrôleur
    fetch('../controllers/AdminController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'demande_id=' + encodeURIComponent(id) + '&action=' + encodeURIComponent(action === 'accepter' ? 'accepter_stage' : 'refuser_stage')
    })
    .then(response => response.text())
    .then(data => {
        // Optionnel : afficher une notification ou traiter la réponse
        // actionsDiv.innerHTML = ... peut être mis à jour ici si besoin
    })
    .catch(error => {
        alert('Erreur lors de la mise à jour du statut.');
        // Remettre le statut à l'ancien si besoin
    });
}

function cancelAction(id) {
    const statusText = document.getElementById('statut-' + id);
    const actionsDiv = document.getElementById('actions-' + id);
    
    // Remettre le statut à 'en attente'
    statusText.textContent = 'en attente';
    
    // Masquer le bouton d'annulation et afficher les boutons d'acceptation/refus
    actionsDiv.innerHTML = `
        <button type="button" onclick="changeStatus('accepter', ${id})">Accepter</button>
        <button type="button" onclick="changeStatus('refuser', ${id})">Refuser</button>
    `;
}
</script>

        <!-- Section Offres -->
        <section id="offresSection" class="content-section">
           <h2>Inscriptions aux Offres de Stage</h2>
<table>
    <thead>
        <tr>
            <th>Nom de l'Étudiant</th>
            <th>Nom de l'Entreprise</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($inscriptions)): ?>
            <?php foreach ($inscriptions as $inscription): ?>
                <tr>
                    <td><?php echo htmlspecialchars($inscription['nom_etudiant'] ?? 'Inconnu'); ?></td>
                    <td><?php echo htmlspecialchars($inscription['entreprise_nom'] ?? 'Non spécifié'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Aucune inscription trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

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
                    // Récupérer les offres de stage depuis la base de données
                    $query = "SELECT * FROM offres_stage";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($offres as $offre) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($offre['entreprise_nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($offre['entreprise_lieu']) . "</td>";
                        echo "<td>" . htmlspecialchars($offre['entreprise_adresse']) . "</td>";
                        echo "<td>" . htmlspecialchars($offre['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($offre['date_limite']) . "</td>";
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

        <!-- Section Étudiants -->
        <section id="etudiantsSection" class="content-section">
            <h2>Liste des Étudiants</h2>
            <form action="admin_dashboard.php" method="POST">
                <input type="text" name="search_term" placeholder="Rechercher par nom ou email" required>
                <button type="submit" name="search">Rechercher</button>
            </form>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Post Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
                <?php if (!empty($etudiants)): ?>
                    <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($etudiant['nom']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['post_nom']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['email']); ?></td>
                        <td>
                            <button onclick="document.getElementById('editForm<?php echo $etudiant['id']; ?>').style.display='block'">Modifier</button>
                            <div id="editForm<?php echo $etudiant['id']; ?>" style="display:none;">
                                <form action="admin_dashboard.php" method="POST">
                                    <input type="hidden" name="student_id" value="<?php echo $etudiant['id']; ?>">
                                    <label for="edit_nom">Nom :</label>
                                    <input type="text" name="edit_nom" value="<?php echo htmlspecialchars($etudiant['nom']); ?>" required>
                                    <label for="edit_post_nom">Post Nom :</label>
                                    <input type="text" name="edit_post_nom" value="<?php echo htmlspecialchars($etudiant['post_nom']); ?>" required>
                                    <label for="edit_prenom">Prénom :</label>
                                    <input type="text" name="edit_prenom" value="<?php echo htmlspecialchars($etudiant['prenom']); ?>" required>
                                    <label for="edit_genre">Genre :</label>
                                    <select name="edit_genre" required>
                                        <option value="Masculin" <?php echo $etudiant['genre'] == 'Masculin' ? 'selected' : ''; ?>>Masculin</option>
                                        <option value="Féminin" <?php echo $etudiant['genre'] == 'Féminin' ? 'selected' : ''; ?>>Féminin</option>
                                    </select>
                                    <label for="edit_email">Email :</label>
                                    <input type="email" name="edit_email" value="<?php echo htmlspecialchars($etudiant['email']); ?>" required>
                                    <label for="edit_promotion">Promotion :</label>
                                    <input type="text" name="edit_promotion" value="<?php echo htmlspecialchars($etudiant['promotion']); ?>" required>
                                    <label for="edit_filiere">Filière :</label>
                                    <input type="text" name="edit_filiere" value="<?php echo htmlspecialchars($etudiant['filiere']); ?>" required>
                                    <label for="edit_telephone">Téléphone :</label>
                                    <input type="text" name="edit_telephone" value="<?php echo htmlspecialchars($etudiant['telephone']); ?>" required>
                                    <button type="submit" name="edit_student">Modifier</button>
                                    <button type="button" onclick="document.getElementById('editForm<?php echo $etudiant['id']; ?>').style.display='none'">Annuler</button>
                                </form>
                            </div>
                            <a href="admin_dashboard.php?delete_id=<?php echo $etudiant['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun étudiant inscrit.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <h2>Ajouter un Nouvel Étudiant</h2>
            <form action="admin_dashboard.php" method="POST">
                <label for="new_nom">Nom :</label>
                <input type="text" id="new_nom" name="new_nom" required>
                
                <label for="new_post_nom">Post Nom :</label>
                <input type="text" id="new_post_nom" name="new_post_nom" required>

                <label for="new_prenom">Prénom :</label>
                <input type="text" id="new_prenom" name="new_prenom" required>

                <label for="new_genre">Genre :</label>
                <select id="new_genre" name="new_genre" required>
                    <option value="Masculin">Masculin</option>
                    <option value="Féminin">Féminin</option>
                </select>
                
                <label for="new_email">Email :</label>
                <input type="email" id="new_email" name="new_email" required>
                
                <label for="new_mot_de_passe">Mot de passe :</label>
                <input type="password" id="new_mot_de_passe" name="new_mot_de_passe" required>
                
                <label for="new_promotion">Promotion :</label>
                <input type="text" id="new_promotion" name="new_promotion" required>

                <label for="new_filiere">Filière :</label>
                <input type="text" id="new_filiere" name="new_filiere" required>

                <label for="new_telephone">Téléphone :</label>
                <input type="text" id="new_telephone" name="new_telephone" required>
                
                <button type="submit" name="add_student">Ajouter</button>
            </form>
            <div style="color: red;"><?php echo $message ?? ''; ?></div>
        </section>


        <!-- Section Statistiques -->
<section id="statistiquesSection" class="content-section">
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
        <p>&copy; 2025 Université Don Bosco de Lubumbashi. Faire la différence.</p>
    </footer>
</body>
</html>