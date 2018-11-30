<?php
/**
 * Configuration
 *
 * @since     Aug 2017
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Service;

class Configuration
{
    protected $files   = [];
    protected $folders = [];

    public function __construct(array $config)
    {
        if (!array_key_exists('files', $config)) {
            throw new \RuntimeException('`files` configuration field is required!');
        }
        $this->files = $config['files'];

        if (array_key_exists('folders', $config)) {
            $this->folders = $config['folders'];
        }
    }

    /**
     * @return array
     */
    public function getFiles():array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getFolders():array
    {
        return $this->folders;
    }

    public function getLocaleFile($locale): string
    {
        return $this->files[$locale] ?? null;
    }
}
