<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\Composer\ComposerMustBeValid;
use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UselessOverridingMethodSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousAbstractClassNamingSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
     */

    'preset' => 'symfony',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
     */

    'ide' => 'phpstorm',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind, that all added `Insights` must belong to a specific `Metric`.
    |
     */

    'exclude' => [
        'build',
        'phpinsights.php',
        'src/Kernel.php',
    ],

    'add' => [
    ],

    'remove' => [
        DisallowYodaComparisonSniff::class,
        ComposerMustBeValid::class,
        SuperfluousAbstractClassNamingSniff::class,
        DisallowMixedTypeHintSniff::class
    ],

    'config' => [
        ForbiddenSetterSniff::class => [
            'exclude' => [
                'src/Entity/GraphicStyle',
                'src/Entity/Designer',
                'src/Entity/Developer',
                'src/Entity/Level',
                'src/Entity/User',
                'src/Entity/Administrator',
                'src/Entity/BaseUser',
            ],
        ],
        UselessOverridingMethodSniff::class => [
            'exclude' => [
                'src/Controller/Admin/DashboardController',
            ],
        ],
        ForbiddenNormalClasses::class => [
            'exclude' => [
                'src/Entity/GraphicStyle',
                'src/Entity/Designer',
                'src/Entity/Developer',
                'src/Entity/Level',
                'src/Entity/Administrator',
            ],
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => true,
        ],
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 5,
        ],
        UnusedParameterSniff::class => [
            'exclude' => [
                'src/DataPersister/UserDataPersister.php',
                'src/Normalizer',
                'src/Controller',
            ],
        ],
        ReturnAssignmentFixer::class => [
            'exclude' => [
                'src/DataPersister/UserDataPersister.php',
            ],
        ],
        ParameterTypeHintSniff::class => [
            'exclude' => [
                'src/DataPersister/UserDataPersister.php',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
     */

    'requirements' => [
        'min-quality' => 100,
        'min-complexity' => 95,
        'min-architecture' => 100,
        'min-style' => 100,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. This accept null value or integer > 0.
    |
     */

    'threads' => null,
];
