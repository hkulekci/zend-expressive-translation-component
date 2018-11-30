<?php
/**
 * Zend Expressive Translation Component
 */
namespace TranslationComponent;

class ModuleConfig
{
    public function __invoke()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
