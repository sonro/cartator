<?php

namespace App\Presentation\Console\Command\SourceAccess;

use App\Core\Application\DataTransfer\Hydrator\SourceQuerierDtoHydrator;
use App\Core\Application\Service\SourceQuerierService;
use App\Core\Application\SourceAccess\SourceQuery\Lister\SourceQueryLister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GenerateQueriersCommand extends Command
{
    protected static $defaultName = 'app:source-access:generate-queriers';

    /**
     * @var SourceQuerierDtoHydrator
     */
    private $hydrator;

    /**
     * @var SourceQueryLister
     */
    private $sourceQueryLister;

    /**
     * @var SourceQuerierService
     */
    private $sourceQuerierService;

    public function __construct(
        SourceQuerierDtoHydrator $hydrator,
        SourceQueryLister $sourceQueryLister,
        SourceQuerierService $sourceQuerierService
    ) {
        $this->hydrator = $hydrator;
        $this->sourceQueryLister = $sourceQueryLister;
        $this->sourceQuerierService = $sourceQuerierService;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Generates SourceQueriers')->setHelp(
            'Scan for SourceQueryInterface implementations, generate '.
                'and persist SourceQuerier object.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->text('Searching for declared SourceQuery classes...');
        $classes = $this->sourceQueryLister->list();
        $dtos = [];
        $io->success(sprintf('Found %d classes', count($classes)));
        $io->text('Hydrating objects...');
        foreach ($classes as $class) {
            $dto = $this->hydrator->createFromClassName($class);
            if ($dto === null) {
                continue;
            }
            $dtos[] = $dto;
        }
        $io->success(sprintf('Hydrated %d objects to persist', count($dtos)));
        $io->text('Persisting SourceQueriers...');
        $queriers = $this->sourceQuerierService->persistMultipleDtos(
            $dtos,
            true
        );
        $io->success(count($queriers).' SourceQueriers persisted!');
    }
}
