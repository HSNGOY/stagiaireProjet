<?php
session_start();
include '../config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        // 1. Vérification dans la table etudiants
        $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            // Etudiant trouvé, vérifier le mot de passe haché
            if (password_verify($mot_de_passe, $etudiant['mot_de_passe'])) {
                // Authentification réussie pour un étudiant
                $_SESSION['email'] = $etudiant['email'];
                $_SESSION['id'] = $etudiant['id'];
                $_SESSION['role'] = 'etudiant';

                header("Location: ../views/mon_stage.php");
                exit();
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        } else {
            // 2. Si l'utilisateur n'est pas trouvé dans etudiants, vérifier dans encadreurs
            $stmt = $pdo->prepare("SELECT * FROM encadreurs WHERE email_encadreur = :email");
            $stmt->execute([':email' => $email]);
            $tuteur = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($tuteur) {
                // Encadreur trouvé, vérifier le mot de passe
                if (password_verify($mot_de_passe, $tuteur['mot_de_passe'])) {
                    // Authentification réussie pour un tuteur (mot de passe déjà haché)
                    $_SESSION['email'] = $tuteur['email_encadreur'];
                    $_SESSION['id'] = $tuteur['id'];
                    $_SESSION['role'] = 'tuteur';

                    header("Location: EncadreurController.php");
                    exit();
                } elseif ($mot_de_passe == $tuteur['mot_de_passe']) {
                    // Mot de passe non haché trouvé, hacher et mettre à jour
                    $motDePasseHache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                    $stmtUpdate = $pdo->prepare("
                        UPDATE encadreurs
                        SET mot_de_passe = :mot_de_passe
                        WHERE id = :id
                    ");

                    $stmtUpdate->execute([
                        ':mot_de_passe' => $motDePasseHache,
                        ':id' => $tuteur['id']
                    ]);

                    // Mettre à jour la session et rediriger
                    $_SESSION['email'] = $tuteur['email_encadreur'];
                    $_SESSION['id'] = $tuteur['id'];
                    $_SESSION['role'] = 'tuteur';

                    header("Location: EncadreurController.php");
                    exit();
                } else {
                    $message = "Email ou mot de passe incorrect.";
                }
            } else {
                // Si aucun utilisateur n'est trouvé
                $message = "Email ou mot de passe incorrect.";
            }
        }
    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        $message = "Erreur de base de données : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Stagiaires</title>
    <link rel="stylesheet" href="../assets/css/styleStage.css">
</head>
<body>
    <header>
        <h1 style="display: inline;">Connexion</h1>
    </header>

    <main>
        <section>
            <form action="login.php" method="POST">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit">Connexion</button>
            </form>
            <div id="message" style="color: #c0392b; font-weight:600; margin-top:10px; text-align:center;">
                <?php echo htmlspecialchars($message); ?>
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
</html>