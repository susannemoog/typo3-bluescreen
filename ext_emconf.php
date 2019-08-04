<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Bluescreen',
    'description' => 'Adds a production exception handler looking like a windows bluescreen',
    'category' => 'plugin',
    'author' => 'Susanne Moog',
    'author_email' => 'bluescreen@susi.dev',
    'author_company' => '',
    'state' => 'stable',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.1',
    'constraints' => array(
        'depends' => array(
            'typo3' => '10.0.0-10.99.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
);
