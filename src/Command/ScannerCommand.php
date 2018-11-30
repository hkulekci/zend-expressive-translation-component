<?php
/**
 * Scanner Command
 *
 * @since     Aug 2017
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TranslationComponent\Service\Configuration;
use TranslationComponent\Service\Scanner;

class ScannerCommand extends Command
{
    /**
     * @var Configuration $config
     */
    private $config;

    /**
     * @var Scanner
     */
    private $scanner;

    /**
     * @param Configuration $config
     * @param Scanner $scanner
     */
    public function __construct(Configuration $config, Scanner $scanner)
    {
        $this->config  = $config;
        $this->scanner = $scanner;
        parent::__construct();
    }

    /**
     * Configures the command
     */
    protected function configure(): void
    {
        $this->setName('translation:scan')
            ->setDescription('Scan given files');
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Scanning started!');

        foreach ($this->config->getFolders() as $folder) {
            \call_user_func_array(
                [$this->scanner, 'extract'],
                $folder
            );
        }

        foreach ($this->config->getFiles() as $locale => $file) {
            \call_user_func([$this->scanner, 'generate'], $file);
        }

        $this->scanner->run();

        $output->writeln(PHP_EOL . 'Ended!');
    }
}
