<?php

namespace App\Infrastructure\Util\ClassFinder;

use App\Core\Application\Util\ClassFinder\ClassFinderInterface;
use HaydenPierce\ClassFinder\ClassFinder;

final class ClassFinderAdapter implements ClassFinderInterface
{
    public function getClassesInNamespaceRecursive(string $namespace): array
    {
        return ClassFinder::getClassesInNamespace($namespace, ClassFinder::RECURSIVE_MODE);
    }
}
