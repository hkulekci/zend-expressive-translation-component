<?php
/**
 * Scanner Command Factory
 *
 * @since     Aug 2017
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Command;

use Interop\Container\ContainerInterface;
use TranslationComponent\Service\Configuration;
use TranslationComponent\Service\Scanner;
use Twig\Environment;

class ScannerCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $configuration = $container->get(Configuration::class);
        $scanner       = $container->get(Scanner::class);
        
        return new ScannerCommand($configuration, $scanner);
    }
}
