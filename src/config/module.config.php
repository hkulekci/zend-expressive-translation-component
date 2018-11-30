<?php

return [
    'translation' => [
        'defaultLocale' => 'en',
        'files' => [
            'en' => 'data/locale/en.po'
        ],
        'folders' => [
            ['src/', '/.*\.php/'],
            ['src/', '/.*\.twig/'],
        ]
    ],
    'twig' => [
        'extensions' => [
            'translation' => \TranslationComponent\Extension\Translation::class,
        ],
    ],
    'routes' => [
        [
            'name'            => 'locale-change',
            'path'            => '/locale-change',
            'middleware'      => \TranslationComponent\Handler\LocaleChangePageHandler::class,
            'allowed_methods' => ['GET'],
        ],
    ],
    'dependencies' => [
        'abstract_factories' => [
            \TranslationComponent\Translator\TranslatorFactory::class,
        ],
        'invokables' => [
            \TranslationComponent\Extension\Translation::class,
        ],
        'factories' => [
            \TranslationComponent\Handler\LocaleChangePageHandler::class     => \TranslationComponent\Handler\LocaleChangePageHandlerFactory::class,
            \TranslationComponent\Middleware\Handler\HandlerInterface::class => \TranslationComponent\Middleware\Handler\HandlerFactory::class,

            \TranslationComponent\Service\Scanner::class                  => \TranslationComponent\Service\ScannerFactory::class,
            \TranslationComponent\Command\ScannerCommand::class           => \TranslationComponent\Command\ScannerCommandFactory::class,
            \TranslationComponent\Service\Configuration::class            => \TranslationComponent\Service\ConfigurationFactory::class,
            \TranslationComponent\Middleware\TranslationMiddleware::class => \TranslationComponent\Middleware\TranslationMiddlewareFactory::class,
        ]
    ],
    'console' => [
        'commands' => [
            \TranslationComponent\Command\ScannerCommand::class
        ],
    ],
    'middleware_pipeline' => [
        'always' => [
            'middleware' => [
                \TranslationComponent\Middleware\TranslationMiddleware::class
            ],
        ],
    ],
];
