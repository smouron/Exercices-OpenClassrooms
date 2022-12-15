<?php
// functions.php

// function isValidRecipe(array $recipe): bool
// {
//     if (array_key_exists('is_enabled', $recipe)) {
//         $isEnabled = $recipe['is_enabled'];
//     } else {
//         $isEnabled = false;
//     }

//     return $isEnabled;
// }

// Contrôle si l'email existe dans les utilisateurs enregistré.
// recupère le nom de l'auteur s'il est bien présent
function displayAuthor(string $authorEmail, array $users): string
{
    for ($i = 0; $i < count($users); $i++) {
        $author = $users[$i];
        if ($authorEmail === $author['email']) {
            // return $author['full_name'] . ' (' . $author['age'] . ' ans)';
            return $author['full_name'] . ' (' . $authorEmail . ')';
        }
    }

    return 'Auteur inconnu';
}

// Contrôle si une recette est active
function getValidRecipes(array $recipes): array
{
    $validRecipes = [];

    foreach ($recipes as $recipe) {
        if (array_key_exists('is_enabled', $recipe)) {
            if ($recipe['is_enabled']) {
                $validRecipes[] = $recipe;
            }
        }
    }

    return $validRecipes;
}

// Contrôle si la recette existe
function getvalidIdRecipe(string $recipe_id, array $recipes): string
{
    $validId = 0;

    foreach ($recipes as $recipe) {
        if (array_key_exists('recipe_id', $recipe)) {
            if ($recipe['recipe_id'] == $recipe_id) {
                $validId = 1;
            }
        }
    }

    return $validId;
}

// Recupérer les données d'1 recette
function getDataRecipe(string $recipe_id, array $recipes): array
{
    foreach ($recipes as $recipe) {
        if (array_key_exists('recipe_id', $recipe)) {
            if ($recipe['recipe_id'] == $recipe_id) {
                $dataRecipe = $recipe;
            }
        }
    }

    return $dataRecipe;
}

return;

// Recupérer les données d'1 utilisateur
function getDataUser(string $user_id, array $users): array
{
    $dataUser = [];
    foreach ($users as $user) {
        if (array_key_exists('user_id', $user)) {
            if ($user['user_id'] == $user_id) {
                $dataUser = $user;
            }
        }
    }

    return $dataUser;
}

return;

// Contrôle si le commentaire existe
function getvalidIdComment(
    string $recipe_id,
    string $comment_id,
    array $comments
): string {
    $validId = 0;

    foreach ($comments as $comment) {
        if (array_key_exists('comment_id', $comment)) {
            if (
                $comment['comment_id'] == $comment_id &&
                $comment['recipe_id'] == $recipe_id
            ) {
                $validId = 1;
            }
        }
    }

    return $validId;
}

// Recupérer les données d'1 commentaire pour 2 recette
function getDataComments(string $recipe_id, array $comments): array
{
    $count = 0;
    $dataComments = [];
    foreach ($comments as $comment) {
        if (array_key_exists('recipe_id', $comment)) {
            if ($comment['recipe_id'] == $recipe_id) {
                $dataComments[$count] = $comment;
                $count++;
            }
        }
    }

    return $dataComments;
}

return;

// Calcule de la note
function calcNote(string $recipe_id, array $comments): string
{
    $note = 0;
    $count = 0;

    foreach ($comments as $comment) {
        if (array_key_exists('ranking', $comment)) {
            if ($comment['recipe_id'] == $recipe_id) {
                $note = $note + $comment['ranking'];
                $count++;
            }
        }
    }

    return $note;
}
return;

// Convertire la note en étoiles
function getStarNote(int $nbAvis, float $note): string
{
    $noteTotal = 0;
    if ($nbAvis >= 1) {
        $noteTotal = $note / $nbAvis;
    }

    $entierTotal = (int) $noteTotal;
    $resteTotal = $noteTotal - $entierTotal;
    $roundTotal = ceil($noteTotal);

    $starNote = '';

    for ($i = 1; $i <= 5; $i++) {
        if ($entierTotal >= $i) {
            $starNote = $starNote . '<i class="fas fa-star"></i>';
        } elseif ($roundTotal >= $i) {
            $starNote = $starNote . '<i class="fas fa-star-half-alt"></i>';
        } else {
            $starNote = $starNote . '<i class="far fa-star"></i>';
        }
    }
    return $starNote;
}

return;

// Convertire la note en étoiles colorées
function getStarNoteColor(int $nbAvis, float $note): string
{
    $noteTotal = 0;
    if ($nbAvis >= 1) {
        $noteTotal = $note / $nbAvis;
    }

    $entierTotal = (int) $noteTotal;
    $resteTotal = $noteTotal - $entierTotal;
    $roundTotal = ceil($noteTotal);

    $starNote = '';

    if ($noteTotal >= 4.5) {
        $starNote = '<div class="text-success me-sm-3">';
    } elseif ($noteTotal > 1) {
        $starNote = '<div class="text-warning me-sm-3">';
    } else {
        $starNote = '<div class="text-danger me-sm-3">';
    }
    for ($i = 1; $i <= 5; $i++) {
        if ($entierTotal >= $i) {
            $starNote = $starNote . '<i class="fas fa-star"></i>';
        } elseif ($roundTotal >= $i) {
            $starNote = $starNote . '<i class="fas fa-star-half-alt"></i>';
        } else {
            $starNote = $starNote . '<i class="far fa-star"></i>';
        }
    }

    $starNote = $starNote . '</div>';
    return $starNote;
}

return;
