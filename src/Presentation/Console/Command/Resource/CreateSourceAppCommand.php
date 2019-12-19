<?php

namespace App\Presentation\Console\Command\Resource;

use App\Core\Application\DataTransfer\Dto\SourceAppDto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\SerializerInterface;

final class CreateSourceAppCommand extends Command
{
    protected static $defaultName = 'app:resource:create-source-app';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $dataDirectory;

    public function __construct(
        SerializerInterface $serializer,
        string $dataDirectory
    ) {
        $this->serializer = $serializer;
        $this->dataDirectory = $dataDirectory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(
            'Create/update a SourceApp json file to load into main app'
        );
        $this->setHelp('Create/update a SourceApp datafile from user input');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $saName = $io->ask('Name of sourceApp');

        $newSa = new SourceAppDto(
            $saName,
            $io->ask("$saName website url"),
            $io->ask("$saName downloads url"),
            $io->confirm('Can new versions be auto-downloaded')
        );

        $storedSa = null;
        $finder = new Finder();

        if (
            $finder
                ->files()
                ->in($this->dataDirectory)
                ->name("$saName.json")
                ->count() === 1
        ) {
            $file = $finder->getIterator()->current();
            $json = file_get_contents($file->getRealPath());
            $storedSa = $this->serializer->deserialize(
                $json,
                SourceAppDto::class,
                'json'
            );
        }

        if ($storedSa === $newSa) {
            $io->note('No changes to SourceApp');

            return;
        }

        $json = $this->serializer->serialize($newSa, 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
        ]);
        $filename = $this->dataDirectory."/$saName.json";
        if (file_put_contents($filename, $json) !== false) {
            $io->success("SourceApp saved to $filename");
        }
    }
}
