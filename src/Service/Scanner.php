<?php
/**
 * Scanner Service
 * Source : https://github.com/oscarotero/GettextRobo
 *
 * @author    Oscar Otero <oom@oscarotero.com>
 */

namespace TranslationComponent\Service;

use FilesystemIterator;
use Gettext\Translations;
use MultipleIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Twig\Environment;

class Scanner
{
    private $iterator;
    private $targets = [];
    private $twig;

    private static $regex;
    private static $suffixes = [
        '.blade.php' => 'Blade',
        '.csv'       => 'Csv',
        '.jed.json'  => 'Jed',
        '.js'        => 'JsCode',
        '.json'      => 'Json',
        '.mo'        => 'Mo',
        '.php'       => ['PhpCode', 'PhpArray'],
        '.po'        => 'Po',
        '.pot'       => 'Po',
        '.twig'      => 'Twig',
        '.xliff'     => 'Xliff',
        '.yaml'      => 'Yaml',
    ];

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $this->iterator = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
    }

    /**
     * Add a new source folder.
     *
     * @param string      $path
     * @param null|string $regex
     *
     * @return $this
     */
    public function extract(string $path, string $regex = null): self
    {
        $directory = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $iterator  = new RecursiveIteratorIterator($directory);

        if ($regex) {
            $iterator = new RegexIterator($iterator, $regex);
        }

        $this->iterator->attachIterator($iterator);

        return $this;
    }

    /**
     * Add a new target.
     *
     * @param string $path
     *
     * @return $this
     */
    public function generate(string $path): self
    {
        $this->targets[] = \func_get_args();

        return $this;
    }

    /**
     * Run the task.
     */
    public function run(): void
    {
        foreach ($this->targets as $targets) {
            $target       = $targets[0];
            $translations = new Translations();
            $this->scan($translations);

            if (is_file($target)) {
                $fn = $this->getFunctionName('from', $target, 'File', 1);
                $translations->mergeWith(Translations::$fn($target));
            }

            foreach ($targets as $target) {
                $fn  = $this->getFunctionName('to', $target, 'File', 1);
                $dir = \dirname($target);
                if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
                }

                $translations->$fn($target);
            }
        }
    }

    /**
     * Execute the scan.
     *
     * @param Translations $translations
     */
    private function scan(Translations $translations): void
    {
        foreach ($this->iterator as $each) {
            foreach ($each as $file) {
                /** @var \SplFileInfo $file */
                if ($file === null || !$file->isFile()) {
                    continue;
                }

                $target = $file->getPathname();
                if ($fn = $this->getFunctionName('addFrom', $target, 'File')) {
                    $translations->$fn($target, ['twig' => $this->twig]);
                }
            }
        }
    }

    /**
     * Get the format based in the extension.
     *
     * @param string $prefix
     * @param string $file
     * @param string $suffix
     * @param int    $key
     * @return null|string
     */
    private function getFunctionName(string $prefix, string $file, string $suffix, int $key = 0): ?string
    {
        if (preg_match(self::getRegex(), strtolower($file), $matches)) {
            $format = self::$suffixes[$matches[1]];

            if (\is_array($format)) {
                $format = $format[$key];
            }

            return sprintf('%s%s%s', $prefix, $format, $suffix);
        }

        return null;
    }

    /**
     * Returns the regular expression to detect the file format.
     *
     * @return string
     */
    private static function getRegex(): string
    {
        if (self::$regex === null) {
            self::$regex = '/('.str_replace('.', '\\.', implode('|', array_keys(self::$suffixes))).')$/';
        }

        return self::$regex;
    }
}
