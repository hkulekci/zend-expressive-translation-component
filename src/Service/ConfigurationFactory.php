<?php
/**
 * Configuration Factory
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Service;

use Interop\Container\ContainerInterface;

class ConfigurationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        if (!isset($config['translation'])) {
            throw new \RuntimeException('`translation` configuration is required!');
        }

        return new Configuration($config['translation']);
    }
}
