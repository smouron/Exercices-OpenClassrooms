<?php
// variables.php

$users = [
    [
        'full_name' => 'Laurène Castor',
        'email' => 'laurene.castor@exemple.com',
        'age' => 28,
        'pseudo' => 'lcastor',
        'password' => '1234',
    ],
    [
        'full_name' => 'Mickaël Andrieu',
        // Il manque , à la fin de cette ligne
        // 'email' => 'mickael.andrieu@exemple.com'
        'email' => 'mickael.andrieu@exemple.com',
        'age' => 34,
        'pseudo' => 'micka',
        'password' => '4321',
    ],
    [
        'full_name' => 'Mathieu Nebra',
        'email' => 'mathieu.nebra@exemple.com',
        'age' => 34,
        'pseudo' => 'mathnebra',
        'password' => 'Mathieu',
    ],
];

$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' =>
            'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, error!',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Couscous',
        'recipe' =>
            'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam fugiat praesentium sit, numquam tenetur quos dicta officiis? Omnis molestiae tempora eveniet! Voluptates, quam consequuntur quis saepe labore consequatur voluptatum. Quam.',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => false,
    ],
    [
        'title' => 'Escalope milanaise',
        'recipe' =>
            'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum, obcaecati. Id accusantium tenetur inventore optio, quam aliquam minima!',
        'author' => 'mathieu.nebra@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Salade Romaine',
        'recipe' =>
            'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate sint dicta laudantium accusamus dolorem, iusto distinctio amet minima! Quibusdam dolore fuga porro cumque maiores id?',
        'author' => 'laurene.castor@exemple.com',
        // mauvaise otrhographe de la clé
        // 'is_enablad' => false,
        'is_enabled' => true,
    ],
    [
        'title' => 'Steack à cheval',
        'recipe' =>
            'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab fugiat labore sed inventore repellendus consequuntur cumque corporis eaque rem voluptates.',
        'author' => 'stephane.mouron@free.fr',
        'is_enabled' => true,
    ],
];
?>
