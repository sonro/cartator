<?php

namespace App\Core\Application\SourceAccess\SourceQuery\Lister;

use App\Core\Application\Util\ClassFinder\ClassFinderInterface;

final class SourceQueryLister
{
    /**
     * @var ClassFinderInterface
     */
    private $classFinder;

    /**
     * @var string
     */
    private $sourceQueryNamespace;

    public function __construct(
        ClassFinderInterface $classFinder,
        string $sourceQueryNamespace
    ) {
        $this->classFinder = $classFinder;
        $this->sourceQueryNamespace = $sourceQueryNamespace;
    }

    public function list(): array
    {
        return $this->classFinder
            ->getClassesInNamespaceRecursive($this->sourceQueryNamespace);
    }
}
