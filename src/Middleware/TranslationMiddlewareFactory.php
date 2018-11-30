<?php
/**
 * Translation Middleware
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Middleware;

use Psr\Container\ContainerInterface;
use TranslationComponent\Middleware\Handler\HandlerInterface;

class TranslationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TranslationMiddleware(
            $container,
            $container->get(HandlerInterface::class)
        );
    }
}
