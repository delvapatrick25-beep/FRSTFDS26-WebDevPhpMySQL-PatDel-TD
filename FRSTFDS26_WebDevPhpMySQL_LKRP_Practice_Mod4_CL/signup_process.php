<?php
// Vérifier que le formulaire est soumis en POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Accès interdit : formulaire non soumis.");
}

// Récupération des champs
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$terms = $_POST['terms'] ?? false;

$errors = [];

// Validation des champs
if (empty($username)) {
    $errors[] = "Le nom d'utilisateur est obligatoire";
} elseif (strlen($username) < 3 || strlen($username) > 20) {
    $errors[] = "Le nom d'utilisateur doit avoir entre 3 et 20 caractères";
} elseif (!preg_match('/^[a-zA-Z0-9\-]+$/', $username)) {
    $errors[] = "Le nom d'utilisateur doit contenir seulement des lettres, chiffres et tirets";
}

if (empty($email)) {
    $errors[] = "L'email est obligatoire";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide";
}

if (empty($password)) {
    $errors[] = "Le mot de passe est obligatoire";
} elseif (strlen($password) < 8) {
    $errors[] = "Le mot de passe doit avoir au minimum 8 caractères";
}

if (empty($password_confirm)) {
    $errors[] = "La confirmation du mot de passe est obligatoire";
} elseif ($password !== $password_confirm) {
    $errors[] = "Les mots de passe ne correspondent pas";
}

if (!$terms) {
    $errors[] = "Vous devez accepter les conditions d'utilisation";
}

// Déterminer si l'inscription est valide
$inscription_valide = empty($errors);

// Sécuriser l'affichage
$username_safe = htmlspecialchars($username);
$email_safe = htmlspecialchars($email);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <h5>Erreurs détectées :</h5>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card p-4 mt-3">
                <p class="text muted">corriger les erreurs et reessayez</p>
                <form methode="POST" action="signup_process.php">
                    <input type="text" class="form-control mb-2" name="username" placeholder="Nom d'utilisateur"
                        value="<?= $username_safe ?>">

                </form>

            </div>






        <?php endif; ?>

        <!-- Message succès -->
        <?php if ($inscription_valide): ?>
            <div class="alert alert-success">
                <h5>Inscription réussie !</h5>
                <ul class="list-unstyled">
                    <li><strong>Nom d'utilisateur:</strong> <?= $username_safe ?></li>
                    <li><strong>Email:</strong> <?= $email_safe ?></li>
                    <li><strong>Inscription:</strong> <?= date('d/m/Y à H:i') ?></li>
                </ul>
                <p>Vous pouvez <a href="index.php">retourner au blog</a>.</p>
            </div>
        <?php endif; ?>

        <!-- Formulaire pour réessayer si erreurs -->
        <?php if (!$inscription_valide): ?>
            <div class="card p-4 mt-3">
                <form method="POST" action="">
                    <input type="text" class="form-control mb-2" name="username" placeholder="Nom d'utilisateur"
                        value="<?= $username_safe ?>">
                    <input type="email" class="form-control mb-2" name="email" placeholder="Email"
                        value="<?= $email_safe ?>">
                    <input type="password" class="form-control mb-2" name="password" placeholder="Mot de passe">
                    <input type="password" class="form-control mb-2" name="password_confirm"
                        placeholder="Confirmer le mot de passe">

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" <?= !empty($terms) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="terms">J'accepte les conditions</label>
                    </div>

                    <button class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>