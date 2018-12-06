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
        ],
        'handler' => \TranslationComponent\Middleware\LocaleHandler\Session::class,
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
            \TranslationComponent\Handler\LocaleChangePageHandler::class           => \TranslationComponent\Handler\LocaleChangePageHandlerFactory::class,
            \TranslationComponent\Middleware\LocaleHandler\HandlerInterface::class => \TranslationComponent\Middleware\LocaleHandler\HandlerFactory::class,

            \TranslationComponent\Service\Scanner::class             => \TranslationComponent\Service\ScannerFactory::class,
            \TranslationComponent\Command\ScannerCommand::class      => \TranslationComponent\Command\ScannerCommandFactory::class,
            \TranslationComponent\Service\Configuration::class       => \TranslationComponent\Service\ConfigurationFactory::class,
            \TranslationComponent\Middleware\LocaleMiddleware::class => \TranslationComponent\Middleware\LocaleMiddlewareFactory::class,
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
                \TranslationComponent\Middleware\LocaleMiddleware::class
            ],
        ],
    ],
];
