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
