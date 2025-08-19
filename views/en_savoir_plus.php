<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Savoir Plus - Stages à l'UDBL</title>
    <style>
        /* Styles généraux */
        body {
            background-color: #ffffff; /* Fond blanc */
            color: #333; /* Texte par défaut */
            font-family: Arial, sans-serif; /* Police de base */
            margin: 0;
            padding: 20px;
        }

        /* Titres */
        h2 {
            color: #0056b3; /* Bleu plus foncé */
            margin-bottom: 20px; /* Espacement sous le titre */
        }

        /* Formulaire */
        #form-etudiant {
            background-color: #f9f9f9; /* Fond léger pour le formulaire */
            padding: 20px; /* Espacement interne */
            border-radius: 8px; /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre légère */
        }

        /* Labels */
        label {
            display: block; /* Affichage en bloc */
            margin-bottom: 5px; /* Espacement sous les labels */
        }

        /* Champs de saisie */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%; /* Largeur complète */
            padding: 10px; /* Espacement interne */
            margin-bottom: 15px; /* Espacement sous chaque champ */
            border: 1px solid #ccc; /* Bordure grise */
            border-radius: 4px; /* Coins arrondis */
        }

        /* Boutons */
        button {
            background-color: #0056b3; /* Bleu foncé */
            color: white; /* Texte en blanc */
            border: none; /* Pas de bordure */
            padding: 10px 15px; /* Espacement interne */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur en main */
            transition: background-color 0.3s; /* Transition douce */
            width: 100%; /* Largeur complète */
        }

        button:hover {
            background-color: #004494; /* Couleur au survol */
        }

        /* Liens */
        a {
            color: #0056b3; /* Bleu foncé */
            text-decoration: none; /* Pas de soulignement */
        }

        a:hover {
            text-decoration: underline; /* Soulignement au survol */
        }

        /* Styles pour les statuts de demande de stage */
        .statut {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 10px;
            font-size: 0.9em;
        }

        .statut.en_attente {
            color: #856404;
            background-color: #fff3cd;
        }

        .statut.acceptee {
            color: #155724;
            background-color: #d4edda;
        }

        .statut.refusee {
            color: #721c24;
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <header>
        <h1>En Savoir Plus sur les Stages à l'UDBL</h1>
        <nav>
            <a href="../index.php?url=accueil"><p>Retour</p></a> |
            <a href="../controllers/traitement_stage.php">Mon Stage</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Les Stages à l'UDBL</h2>
            <p>
                À l'Université Don Bosco de Lubumbashi (UDBL), les stages sont régis par la loi N-12/004 du 20 juillet 2012 relative à l'enseignement supérieur, à la recherche scientifique et à l'innovation en République Démocratique du Congo, qui définit les stages comme des activités pratiques encadrées par un enseignant-chercheur ou un professeur permettant aux étudiants de mettre en application les connaissances et compétences acquises en cours de formation.
            </p>
            <p>
                Pour l'Université Don Bosco de Lubumbashi, le stage est un moment de vie, d'expérimentation, de socialisation et de professionnalisation de nos étudiants. Il met nos étudiants en situation professionnelle et il bonifie leurs compétences.
            </p>
        </section>

        <section>
            <h2>Notre Cursus Académique</h2>
            <p>
                Au sein de nos deux facultés non ecclésiastiques, à savoir la Faculté des Sciences Informatiques et celle des Sciences de Gestion et Ingénierie Financière, nous formons des spécialistes en informatique sur deux cycles :
            </p>
            <ul>
                <li><b>En Gestion et Ingénierie Financière (BAC+3 & BAC+5) :</b> Licence et Master dans quatre grands départements :
                    <ul>
                        <li>Gestion des Entreprises et Ingénierie Financière</li>
                        <li>Management Commercial et Marketing</li>
                        <li>Gestion des Affaires Publiques</li>
                        <li>Divertissement Agroalimentaire et Industriel</li>
                    </ul>
                </li>
                <li><b>En Informatique (BAC+4 & BAC+6) :</b> Licence et Master dans trois grands départements :
                    <ul>
                        <li>Réseaux</li>
                        <li>Génie Logiciel</li>
                        <li>Design et Multimédia</li>
                    </ul>
                </li>
            </ul>
        </section>

        <section>
            <h2>Note d'Informations Générales</h2>
            <p>L'appréciation portera sur :</p>
            <ul>
                <li>La ponctualité, l'assiduité et la concentration au travail ;</li>
                <li>La motivation et l'intérêt de et au travail ;</li>
                <li>La qualité du travail ;</li>
                <li>L'esprit de collaboration, la sociabilité et l'honnêteté ;</li>
                <li>La capacité à réaliser un travail dans un délai donné ;</li>
                <li>Le sens des responsabilités et le leadership dans l'exécution des tâches confiées ;</li>
                <li>La prise d'initiative dans le cadre des instructions reçues ;</li>
                <li>La facilité d'assimilation de la technologie dans l'organisation.</li>
            </ul>
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