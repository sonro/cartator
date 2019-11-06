<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class SourceDbKernelTestCase extends KernelTestCase
{
    use SourceDbTestTrait;
}
