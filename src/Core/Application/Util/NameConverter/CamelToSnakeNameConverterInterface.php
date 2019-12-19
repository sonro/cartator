<?php

namespace App\Core\Application\Util\NameConverter;

interface CamelToSnakeNameConverterInterface
{
    public function normalize(string $input): string;

    public function denomalize(string $input): string;
}
