<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion des Stagiaires</title>
    <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur STAGEnet </h1><br/>
        <nav>
            <ul>
                <li><a href="controllers/login.php">Mon Stage</a></li>
                <li><a href="controllers/DemandeStageController.php">Lettre de Stage</a></li>
                <!--<li><a href="entreprises_collaborateurs.php">Entreprises Collaboratrices</a></li>-->
                <li><a href="../controllers/OffreController.php">Offres de Stages</a></li>
                <!--<li><a href="en_savoir_plus.php">En Savoir Plus</a></li>-->
                <li><a href="controllers/login.php">connexion</a></li> <!-- Lien pour déconnexion -->
                <li><a href="controllers/login_admin.php">administrateur</a></li><!-- connexion admin -->
            </ul>
        </nav>
    </header>

    <main>
        <!-- Section Mon Stage -->
        <section class="card">
            <img src="../images/stage3.jpeg" alt="Mon Stage">
            <div class="text-container">
                <p class="section-title"><a href="controllers/DemandeStageController.php">Mon Stage</a></p>
                <p>consulter les informations survotre stage,et effectuer vos taches.<br/>
                assurer votre stage au pret de responsables academaiques
                </p>
            </div>
        </section>

        <!-- Section Lettre de Stage -->
        <section class="card">
            <img src="../images/stage6.jpeg" alt="Lettre de Stage">
            <div class="text-container">
                <p class="section-title"><a href="views/etudiant_form.php">Lettre de Stage</a></p>
                <p>Accédez aux modèles et aux informations concernant la lettre de stage.</p>
            </div>
        </section>

        <!-- Section Entreprises Collaboratrices -->
       <!-- <section class="card">
            <img src="../images/stage7.jpeg" alt="Entreprises Collaboratrices">
            <div class="text-container">
                <p class="section-title"><a href="entreprises_collaborateurs.php">Entreprises Collaboratrices</a></p>
                <p>Consultez la liste des entreprises et des collaborateurs disponibles.</p>
            </div>
        </section>-->

        <!-- Section Offres de Stages -->
        <section class="card">
            <img src="../images/stage5.jpeg" alt="Offres de Stages">
            <div class="text-container">
                <p class="section-title"><a href="views/offres_stages.php">Offres de Stages</a></p>
                <p>Découvrez les offres de stages disponibles pour les étudiants.</p>
            </div>
        </section>

        <!-- Section En Savoir Plus -->
        <section class="card">
            <img src="../images/stage8.jpeg" alt="En Savoir Plus">
            <div class="text-container">
                <p class="section-title"><a href="views/en_savoir_plus.php">En Savoir Plus</a></p>
                <p>Renseignez-vous sur le processus de stage et les ressources disponibles.</p>
            </div>
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