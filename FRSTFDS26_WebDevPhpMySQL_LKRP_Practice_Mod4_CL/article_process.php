<?php

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
if ($date !== '') 
    {
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


?>
