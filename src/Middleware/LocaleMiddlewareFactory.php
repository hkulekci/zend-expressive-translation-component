<?php
/**
 * Translation Locale Middleware
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Middleware;

use Psr\Container\ContainerInterface;
use TranslationComponent\Middleware\LocaleHandler\HandlerInterface;

class LocaleMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LocaleMiddleware(
            $container,
            $container->get(HandlerInterface::class)
        );
    }
}
