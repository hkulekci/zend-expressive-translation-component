<?php
/**
 * Translation Middleware
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Middleware\LocaleHandler;

use Psr\Container\ContainerInterface;

class HandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        if (!isset($config['translation'])) {
            throw new \RuntimeException('`translation` configuration is required!');
        }
        if (isset($config['translation']['handler']) && class_exists($config['translation']['handler'])) {
            return new $config['translation']['handler'];
        }

        return new Session();
    }
}
