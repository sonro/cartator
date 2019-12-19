<?php

namespace App\Presentation\Console\Command\Resource;

use App\Core\Application\DataTransfer\Dto\SourceAppDto;
use App\Core\Application\Service\SourceAppService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\SerializerInterface;

final class LoadSourceAppsCommand extends Command
{
    protected static $defaultName = 'app:resource:load-source-apps';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var SourceAppService
     */
    private $service;

    /**
     * @var string
     */
    private $dataDirectory;

    public function __construct(
        SerializerInterface $serializer,
        SourceAppService $service,
        string $dataDirectory
    ) {
        $this->serializer = $serializer;
        $this->service = $service;
        $this->dataDirectory = $dataDirectory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Load and persist supported SourceApps');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $sourceAppDtos = [];
        $finder = new Finder();
        $finder
            ->files()
            ->in($this->dataDirectory)
            ->name('*.json');

        /** @var SplFileInfo */
        foreach ($finder as $file) {
            $json = file_get_contents($file->getRealPath());
            $sourceAppDtos[] = $this->serializer->deserialize(
                $json,
                SourceAppDto::class,
                'json'
            );
        }
        $this->service->persistMultipleDtos($sourceAppDtos);
        $io->success('SourceApps loaded');
    }
}
