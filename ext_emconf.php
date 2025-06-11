<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Easy Slug',
    'description' => 'Updates the slug of a page automatically and logically when renaming a page or moving it around.',
    'category' => 'fe',
    'version' => '1.0.0',
    'module' => '',
    'state' => 'stable',
    'lockType' => '',
    'author' => 'Xavier Perseguers',
    'author_email' => 'xavier@causal.ch',
    'author_company' => 'Causal Sàrl',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.4.99',
            'typo3' => '11.5.0-13.4.99',
            'redirects' => '10.4.0-',
        ],
        'conflicts' => [
            'slug_autoupdate' => '',
        ],
        'suggests' => [],
    ],
];
