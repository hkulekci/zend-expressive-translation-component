<?php
/**
 * Translator Factory
 *
 * @since     Aug 2017
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Translator;

use Gettext\Translations;
use Gettext\Translator as BaseTranslator;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use TranslationComponent\Service\Configuration;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class TranslatorFactory implements AbstractFactoryInterface
{
    private function build(ContainerInterface $container, $locale): BaseTranslator
    {
        /**
         * @var Configuration $configuration
         */
        $configuration = $container->get(Configuration::class);

        $t = new Translator();
        $translationFile = $configuration->getLocaleFile($locale);
        if ($translationFile === null) {
            throw new \RuntimeException('Translation file not found error!');
        }
        $translations = Translations::fromPoFile($translationFile);
        $t->loadTranslations($translations);

        return $t;
    }

    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        $config = $container->get('config');
        $locale = $this->getLocaleFromServiceName($requestedName);

        if (isset($config['translation']['files']) && \is_array($config['translation']['files'])) {
            return \array_key_exists(
                $locale,
                $config['translation']['files']
            );
        }

        return false;
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->build($container, $this->getLocaleFromServiceName($requestedName));
    }

    private function getLocaleFromServiceName($name)
    {
        return str_replace('_locale', '', $name);
    }
}
