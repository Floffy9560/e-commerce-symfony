<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    '@fullcalendar/core' => [
        'version' => '6.1.18',
    ],
    '@fullcalendar/daygrid' => [
        'version' => '6.1.18',
    ],
    '@fullcalendar/interaction' => [
        'version' => '6.1.18',
    ],

    '@fullcalendar/core/index.js' => [
        'version' => '6.1.18',
    ],
    '@fullcalendar/core/internal.js' => [
        'version' => '6.1.18',
    ],

    'preact/hooks' => [
        'version' => '10.12.1',
    ],
    '@fullcalendar/list' => [
        'version' => '6.1.18',
    ],
    '@fullcalendar/core/locales/fr' => [
        'version' => '6.1.18',
    ],
    // importation de preact 
    // 'preact' => [
    //     'version' => '10.12.1',
    // ],
    // 'preact/compat' => [
    //     'version' => '10.12.1',
    // ],
    // '@fullcalendar/core/preact.js' => [
    //     'version' => '6.1.18',
    // ],
    'preact' => [
        'url' => 'https://cdn.jsdelivr.net/npm/preact@10.12.1/dist/preact.module.js',
    ],
    'preact/compat' => [
        'url' => 'https://cdn.jsdelivr.net/npm/preact@10.12.1/compat/dist/compat.module.js',
    ],
    '@fullcalendar/core/preact.js' => [
        'url' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.18/preact.js',
    ],
];


// return [
//     'app' => [
//         'path' => './assets/app.js',
//         'entrypoint' => true,
//     ],
//     '@fullcalendar/core' => [
//         'path' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.18/index.global.min.js',
//     ],
//     '@fullcalendar/daygrid' => [
//         'path' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.18/index.global.min.js',
//     ],
//     '@fullcalendar/interaction' => [
//         'path' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.18/index.global.min.js',
//     ],
//     '@fullcalendar/list' => [
//         'path' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.18/index.global.min.js',
//     ],
// ];
