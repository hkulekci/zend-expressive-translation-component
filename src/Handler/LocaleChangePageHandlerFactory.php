<?php
/**
 * Translation Middleware
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Handler;

use Psr\Container\ContainerInterface;
use TranslationComponent\Service\Configuration;

class LocaleChangePageHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $configuration = $container->get(Configuration::class);
        return new LocaleChangePageHandler($configuration);
    }
}
