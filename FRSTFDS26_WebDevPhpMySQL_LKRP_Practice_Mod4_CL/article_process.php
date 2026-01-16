<?php

// 0. Initialiser le tableau des erreurs
$errors = [];

// Récupération des données du formulaire
$titre = htmlspecialchars(trim($_POST["titre"] ?? ''));
$contenu = htmlspecialchars(trim($_POST["contenu"] ?? ''));
$auteur = htmlspecialchars(trim($_POST["auteur"] ?? ''));
$categorie = htmlspecialchars(trim($_POST["categorie"] ?? ''));
$date = htmlspecialchars(trim($_POST["date"] ?? ''));

// 1. Vérifier champs obligatoires
if ($titre === '') {
    $errors[] = "Le titre est obligatoire";
}

if ($contenu === '') {
    $errors[] = "Le contenu est obligatoire";
}

if ($auteur === '') {
    $errors[] = "L'auteur est obligatoire";
}

if ($categorie === '') {
    $errors[] = "La catégorie est obligatoire";
}

if ($date === '') {
    $errors[] = "La date est obligatoire";
}

// 2. Vérifier longueurs
if ($titre !== '' && (strlen($titre) < 5 || strlen($titre) > 100)) {
    $errors[] = "Le titre doit contenir entre 5 et 100 caractères";
}

if ($contenu !== '' && (strlen($contenu) < 20 || strlen($contenu) > 1000)) {
    $errors[] = "Le contenu doit contenir entre 20 et 1000 caractères";
}

if ($auteur !== '' && (strlen($auteur) < 3 || strlen($auteur) > 50)) {
    $errors[] = "L'auteur doit contenir entre 3 et 50 caractères";
}

// 3. Validation de la date
if ($date !== '') {
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);

    if (!$dateObj) {
        $errors[] = "La date n'est pas valide";
    } elseif ($dateObj > new DateTime()) {
        $errors[] = "La date ne peut pas être dans le futur";
    }
}

// 4. Validation de la catégorie
$categories_valides = ['Tutoriels', 'Ressources', 'Actualités'];

if ($categorie !== '' && !in_array($categorie, $categories_valides)) {
    $errors[] = "La catégorie sélectionnée n'est pas valide";
}

// 5. Résultat final
$article_valide = empty($errors);


$titre_safe = htmlspecialchars($titre);
$contenu_safe = htmlspecialchars($contenu);
$auteur_safe = htmlspecialchars($auteur);
$categorie_safe = htmlspecialchars($categorie);
$date_safe = htmlspecialchars($date);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>

    <!-- Bootstrap CSS depuis CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Mon Blog</span>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <h1>Mon Blog</h1>
        <p>Bienvenue sur mon blog. Découvrez mes articles.</p>

        <!-- Section: Confirmation -->
        <h2 class="mt-5">Confirmation d'envoi de message</h2>
        <?php
        if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Erreurs détectées :</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($article_valide): ?>
            <div class="alert alert-success">
                <h5>Article créé avec succès !</h5>
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><?= $titre_safe ?></h6>
                        <p><?= $contenu_safe ?></p>
                        <small>Par <?= $auteur_safe ?> | Catégorie: <?= $categorie_safe ?> | <?= $date_safe ?></small>
                    </div>
                </div>
                <small class="text-muted">
                    Sécurité : Toutes les données affichées ont été nettoyées avec htmlspecialchars()
                </small>
            </div>
        <?php endif; ?>

    </div>


    <script src="script.js"></script>
</body>

</html>