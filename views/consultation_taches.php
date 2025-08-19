<!DOCTYPE html>
<html>

<head>
    <title>Interface Encadreur - Carnet de Stage</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">

    <!-- Ajoutez ici d'autres feuilles de style spécifiques à cette vue -->
</head>

<body>

    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Carnet</span> de Stage</h1>
            </div>

        </div>
    </header>

    <div class="container">

        <?php
        // Afficher les messages d'erreur ou de succès (s'ils existent)
        if (isset($_SESSION['erreur'])) {
            echo '<div class="error-message">' . htmlspecialchars($_SESSION['erreur']) . '</div>';
            unset($_SESSION['erreur']); // Supprimer le message après l'affichage
        }
        if (isset($_SESSION['succes'])) {
            echo '<div class="success-message">' . htmlspecialchars($_SESSION['succes']) . '</div>';
            unset($_SESSION['succes']); // Supprimer le message après l'affichage
        }
        ?>

        <section class="main-section">
            <h2>Carnet de Stage - <?php echo htmlspecialchars($nom_etudiant ?? ''); ?></h2>

            <table class="taches-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Travail du jour</th>
                        <th>But de la tâche</th>
                        <th>Matériel utilisé</th>
                        <th>Temps prévu</th>
                        <th>Mode opératoire</th>
                        <th>Remarque Encadreur</th>
                        <th>Cote Tâche</th>
                        <th>Visa Encadreur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($taches)) : ?>
                    <?php foreach ($taches as $tache) : ?>
                    <tr>
                        <td data-label="Date"><?php echo htmlspecialchars($tache['date']); ?></td>
                        <td data-label="Travail du jour"><?php echo htmlspecialchars($tache['travail_jour']); ?>
                        </td>
                        <td data-label="But de la tâche"><?php echo htmlspecialchars($tache['but_tache']); ?></td>
                        <td data-label="Matériel utilisé"><?php echo htmlspecialchars($tache['materiel_utilise']); ?>
                        </td>
                        <td data-label="Temps prévu"><?php echo htmlspecialchars($tache['temps_prevu']); ?></td>
                        <td data-label="Mode opératoire"><?php echo htmlspecialchars($tache['mode_operatoire']); ?>
                        </td>
                        <td data-label="Remarque Encadreur">
                            <form class="tache-form"
                                action="index.php?url=consultation_taches&action=traiterSoumission" method="post">
                                <input type="hidden" name="carnet_id"
                                    value="<?php echo htmlspecialchars($tache['id']); ?>">
                                <textarea
                                    name="remarque_encadreur"><?php echo htmlspecialchars($tache['remarque_encadreur']); ?></textarea>
                        </td>
                        <td data-label="Cote Tâche">
                            <input type="number" name="cote_tache" min="0" max="20"
                                value="<?php echo htmlspecialchars($tache['cote_tache']); ?>">
                        </td>
                        <td data-label="Visa Encadreur">
                            <input type="checkbox" name="visa_encadreur"
                                <?php echo $tache['visa_encadreur'] ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="9">Aucune tâche trouvée pour cet étudiant.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="submit">Mettre à jour</button>
            </form>
        </section>
    </div>

</body>

</html>