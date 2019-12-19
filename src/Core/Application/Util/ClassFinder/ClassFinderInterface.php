<?php

namespace App\Core\Application\Util\ClassFinder;

interface ClassFinderInterface
{
    public function getClassesInNamespaceRecursive(string $namespace): array;
}
