<?php
/**
 * Configuration Factory
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Service;

use Interop\Container\ContainerInterface;
use Twig\Environment;

class ScannerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $twig = $container->get(Environment::class);

        return new Scanner($twig);
    }
}
