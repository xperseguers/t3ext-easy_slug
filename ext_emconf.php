<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Easy Slug',
    'description' => 'Updates the slug of a page automatically and logically when renaming a page or moving it around.',
    'category' => 'fe',
    'shy' => 0,
    'version' => '0.1.0-dev',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'alpha',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 0,
    'lockType' => '',
    'author' => 'Xavier Perseguers',
    'author_email' => 'xavier@causal.ch',
    'author_company' => 'Causal Sàrl',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-7.4.99',
            'typo3' => '10.4.0-10.4.99',
            'redirects' => '10.4.0-',
        ],
        'conflicts' => [
            'slug_autoupdate' => '',
        ],
        'suggests' => [],
    ],
    '_md5_values_when_last_written' => '',
];
