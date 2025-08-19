<?php
session_start();
include '../config.php';

// Vérifiez si l'étudiant est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../controllers/login.php?error=Vous devez être connecté.");
    exit();
}

$etudiant_id = intval($_SESSION['id']);

// Vérifiez si un encadreur existe déjà pour cet étudiant
$stmt = $pdo->prepare("SELECT * FROM encadreurs WHERE etudiant_id = ?");
$stmt->execute([$etudiant_id]);
$encadreur = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageNEt - Mon Stage </title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
    <h1 style="display: inline;">Mon Stage</h1>
    <div class="header-actions">
        <a href="../controllers/ProfilControlleur.php" class="profil-button">Profil
            <div class="notification" style="position: relative;">
                <span class="indicator" style="position: absolute; top: 0; right: 0; width: 10px; height: 10px; border-radius: 50%; background-color: green;"></span>
            </div>
        </a>
    </div>
</header>

    <?php // Les variables $demandes_acceptees, $carnet_taches, $stages sont fournies par le contrôleur traitement_stage.php ?>
    <main>
        <h2>Stages en Cours</h2>
        <p>Bienvenue dans la section "Mon Stage". Ici, vous pouvez visualiser et gérer les détails de votre stage.</p>
        <section>
            <h2>Démarrer un Stage</h2>
            <button onclick="document.getElementById('demarrerStage').style.display='block'">Démarrer votre stage</button>
        </section>
        <section>
              <h2>Demandes de Stage Acceptées</h2>
            <form method="get" action="" id="form-select-demande">
                <label for="demande_id">Sélectionnez une demande acceptée :</label>
                <select name="demande_id" id="demande_id">
                    <?php foreach ($demandes_acceptees as $demande): ?>
                        <option value="<?php echo $demande['id']; ?>" <?php echo (isset($demande_id_selectionnee) && $demande_id_selectionnee == $demande['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($demande['entreprise_nom']); ?> (<?php echo htmlspecialchars($demande['entreprise_lieu']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
           <?php if ($encadreur): ?>
    <!-- Afficher les informations de l'encadreur existant -->
    <h2>Informations de l'encadreur</h2>
    <p>Nom : <?php echo htmlspecialchars($encadreur['nom_encadreur']); ?></p>
    <p>Poste : <?php echo htmlspecialchars($encadreur['poste_encadreur']); ?></p>
    <p>Email : <?php echo htmlspecialchars($encadreur['email_encadreur']); ?></p>
    <p>Téléphone : <?php echo htmlspecialchars($encadreur['telephone_encadreur']); ?></p>

    <!-- Bouton Modifier (qui redirige vers un formulaire de modification) -->
    <a href="modifier_encadreur.php">Modifier les informations de l'encadreur</a>

<?php else: ?>
    <!-- Afficher le formulaire d'enregistrement si aucun encadreur n'est enregistré -->
    <button id="btn-encadreur" style="margin-bottom: 10px;">Renseigner les informations de l'encadreur</button>
    <div id="form-encadreur" style="display:none; margin-bottom: 20px;">
        <form action="../controllers/traitement_encadreur.php" method="POST">
            <input type="hidden" name="etudiant_id" value="<?php echo $_SESSION['id']; ?>">
            <label for="nom_encadreur">Nom de l'encadreur :</label>
            <input type="text" id="nom_encadreur" name="nom_encadreur" required>
            <label for="poste_encadreur">Poste de l'encadreur :</label>
            <input type="text" id="poste_encadreur" name="poste_encadreur" required>
            <label for="email_encadreur">Email de l'encadreur :</label>
            <input type="email" id="email_encadreur" name="email_encadreur" required>
            <label for="telephone_encadreur">Téléphone de l'encadreur :</label>
            <input type="text" id="telephone_encadreur" name="telephone_encadreur" required>
            <button type="submit">Enregistrer</button>
            <button type="button" onclick="document.getElementById('form-encadreur').style.display='none'">Annuler</button>
        </form>
    </div>
    <script>
        document.getElementById('btn-encadreur').onclick = function() {
            var form = document.getElementById('form-encadreur');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        };
    </script>
<?php endif; ?>
          
            <script>
                // Affiche le formulaire d'ajout de tâche après sélection
                document.getElementById('demande_id').addEventListener('change', function() {
                    document.getElementById('form-select-demande').submit();
                    setTimeout(function() {
                        var formTache = document.querySelector('form[action="../controllers/traitement_carnet.php"]');
                        if(formTache) {
                            formTache.scrollIntoView({behavior: 'smooth'});
                        }
                    }, 500);
                });
                // Si une demande est déjà sélectionnée, scroller automatiquement sur le formulaire
                window.addEventListener('DOMContentLoaded', function() {
                    var formTache = document.querySelector('form[action="../controllers/traitement_carnet.php"]');
                    if(formTache && document.getElementById('demande_id').value) {
                        formTache.scrollIntoView({behavior: 'smooth'});
                    }
                });
            </script>
            <?php if (empty($demandes_acceptees)): ?>
                <p>Aucune demande acceptée.</p>
            <?php endif; ?>
        </section>
        <section>
        
            <h2>Carnet de Stage - <?php echo !empty($nom_entreprise_selectionnee) ? htmlspecialchars($nom_entreprise_selectionnee) : 'Étudiant'; ?></h2>

            <form action="../controllers/traitement_carnet.php" method="POST">
                <input type="hidden" name="etudiant_id" value="<?php echo $_SESSION['id']; ?>">
                <input type="hidden" name="action" value="ajouter_tache">
                <input type="hidden" name="demande_id" value="<?php echo isset($demande_id_selectionnee) ? htmlspecialchars($demande_id_selectionnee) : ''; ?>">

                <label for="travail_du_jour">Travail du jour :</label>
                <textarea id="travail_du_jour" name="travail_du_jour" required></textarea>

                <label for="but">But de la tâche :</label>
                <textarea id="but" name="but" required></textarea>

                <label for="materiel">Matériel utilisé :</label>
                <textarea id="materiel" name="materiel" required></textarea>

                <label for="temps_prevu">Temps prévu :</label>
                <input type="time" id="temps_prevu" name="temps_prevu" required>

                <label for="mode_operatoire">Mode opératoire :</label>
                <textarea id="mode_operatoire" name="mode_operatoire" required></textarea>

                <button type="submit">Ajouter</button>
            </form>
        </section>


        <section>
           <h3>Tâches Enregistrées</h3>
    <ul>
    <?php if (isset($carnet_taches) && is_array($carnet_taches) && !empty($carnet_taches)): ?>
        <?php foreach ($carnet_taches as $tache): ?>
            <li>
                <strong>Date :</strong> <?php echo isset($tache['date']) ? htmlspecialchars($tache['date']) : 'N/A'; ?><br>
                <strong>Travail du jour :</strong> <?php echo isset($tache['travail_du_jour']) ? htmlspecialchars($tache['travail_du_jour']) : 'N/A'; ?><br>
                <strong>But :</strong> <?php echo isset($tache['but']) ? htmlspecialchars($tache['but']) : 'N/A'; ?><br>
                <strong>Matériel :</strong> <?php echo isset($tache['materiel']) ? htmlspecialchars($tache['materiel']) : 'N/A'; ?><br>
                <strong>Temps prévu :</strong> <?php echo isset($tache['temps_prevu']) ? htmlspecialchars($tache['temps_prevu']) : 'N/A'; ?><br>
                <strong>Mode opératoire :</strong> <?php echo isset($tache['mode_operatoire']) ? htmlspecialchars($tache['mode_operatoire']) : 'N/A'; ?><br>

                <?php if (isset($tache['remarque_encadreur']) && !empty($tache['remarque_encadreur'])): ?>
                    <strong>Remarque de l'encadreur :</strong> <?php echo htmlspecialchars($tache['remarque_encadreur']); ?><br>
                <?php endif; ?>

                <strong>Cote de la tâche :</strong> <?php echo isset($tache['cote_tache']) ? htmlspecialchars($tache['cote_tache']) : 'N/A'; ?><br>

                <strong>Visa de l'encadreur :</strong> <?php echo isset($tache['visa_encadreur']) ? ($tache['visa_encadreur'] ? 'Oui' : 'Non') : 'N/A'; ?><br>

                <strong>Visa du superviseur :</strong> <?php echo isset($tache['visa_superviseur']) ? ($tache['visa_superviseur'] ? 'Oui' : 'Non') : 'N/A'; ?><br>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Aucune tâche enregistrée.</li>
    <?php endif; ?>
</ul>
        </section>

        <section>
            <button onclick="window.location.href='rapport.php'">Rapport de Stage</button>
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