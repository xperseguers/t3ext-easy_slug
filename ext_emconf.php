<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Easy Slug',
    'description' => 'Updates the slug of a page automatically and logically when renaming a page or moving it around.',
    'category' => 'fe',
    'version' => '0.2.0-dev',
    'module' => '',
    'state' => 'beta',
    'lockType' => '',
    'author' => 'Xavier Perseguers',
    'author_email' => 'xavier@causal.ch',
    'author_company' => 'Causal Sàrl',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.2.99',
            'typo3' => '10.4.0-12.4.99',
            'redirects' => '10.4.0-',
        ],
        'conflicts' => [
            'slug_autoupdate' => '',
        ],
        'suggests' => [],
    ],
];
