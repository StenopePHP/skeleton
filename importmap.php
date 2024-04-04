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
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@swup/debug-plugin' => [
        'version' => '4.0.4',
    ],
    '@swup/fade-theme' => [
        'version' => '2.0.0',
    ],
    '@swup/forms-plugin' => [
        'version' => '3.5.1',
    ],
    '@swup/progress-plugin' => [
        'version' => '3.1.2',
    ],
    '@swup/scroll-plugin' => [
        'version' => '3.3.2',
    ],
    '@swup/slide-theme' => [
        'version' => '2.0.0',
    ],
    '@swup/plugin' => [
        'version' => '4.0.0',
    ],
    '@swup/theme' => [
        'version' => '2.1.0',
    ],
    'swup' => [
        'version' => '4.6.1',
    ],
    'scrl' => [
        'version' => '2.0.0',
    ],
    'delegate-it' => [
        'version' => '6.1.0',
    ],
    'path-to-regexp' => [
        'version' => '6.2.1',
    ],
];
