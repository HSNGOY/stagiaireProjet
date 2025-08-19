<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1>Admin Manager</h1>
        <a href="../index.php?url=accueil" class="btn-home">Accueil</a>
    </header>
    <div class="dashboard-layout">
        <?php include __DIR__ . '/menu.php'; renderMenu('etudiants'); ?>
        <main>
            <section>
                <h2>Liste des Étudiants</h2>
                <form action="etudiants.php" method="POST">
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
                        <th>Infos</th>
                    </tr>
                    <?php if (!empty($etudiants)): ?>
                        <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($etudiant['nom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['post_nom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['prenom'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['email'] ?? ''); ?></td>
                            <td>
                                
                                <button onclick="document.getElementById('editForm<?php echo $etudiant['id']; ?>').style.display='block'" style="margin-left:10px;">Modifier</button>
                                <div id="editForm<?php echo $etudiant['id']; ?>" style="display:none;">
                                    <form action="etudiants.php" method="POST">
                                        <input type="hidden" name="student_id" value="<?php echo $etudiant['id']; ?>">
                                        <label for="edit_nom">Nom :</label>
                                        <input type="text" name="edit_nom" value="<?php echo htmlspecialchars($etudiant['nom'] ?? ''); ?>" required>
                                        <label for="edit_post_nom">Post Nom :</label>
                                        <input type="text" name="edit_post_nom" value="<?php echo htmlspecialchars($etudiant['post_nom'] ?? ''); ?>" required>
                                        <label for="edit_prenom">Prénom :</label>
                                        <input type="text" name="edit_prenom" value="<?php echo htmlspecialchars($etudiant['prenom'] ?? ''); ?>" required>
                                        <label for="edit_genre">Genre :</label>
                                        <select name="edit_genre" required>
                                            <option value="Masculin" <?php echo ($etudiant['genre'] ?? '') == 'Masculin' ? 'selected' : ''; ?>>Masculin</option>
                                            <option value="Féminin" <?php echo ($etudiant['genre'] ?? '') == 'Féminin' ? 'selected' : ''; ?>>Féminin</option>
                                        </select>
                                        <label for="edit_email">Email :</label>
                                        <input type="email" name="edit_email" value="<?php echo htmlspecialchars($etudiant['email'] ?? ''); ?>" required>
                                        <label for="edit_promotion">Promotion :</label>
                                        <input type="text" name="edit_promotion" value="<?php echo htmlspecialchars($etudiant['promotion'] ?? ''); ?>" required>
                                        <label for="edit_filiere">Filière :</label>
                                        <input type="text" name="edit_filiere" value="<?php echo htmlspecialchars($etudiant['filiere'] ?? ''); ?>" required>
                                        <label for="edit_telephone">Téléphone :</label>
                                        <input type="text" name="edit_telephone" value="<?php echo htmlspecialchars($etudiant['telephone'] ?? ''); ?>" required>
                                        <button type="submit" name="edit_student">Modifier</button>
                                        <button type="button" onclick="document.getElementById('editForm<?php echo $etudiant['id']; ?>').style.display='none'">Annuler</button>
                                    </form>
                                </div>
                                <a href="etudiants.php?delete_id=<?php echo $etudiant['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');" style="margin-left:10px;">Supprimer</a>
                            </td>
                            <td>
                                <a href="../controllers/InfosEtudiantController.php?id=<?php echo $etudiant['id']; ?>" class="btn-view">Voir fiche</a>
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
                <form action="etudiants.php" method="POST">
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
