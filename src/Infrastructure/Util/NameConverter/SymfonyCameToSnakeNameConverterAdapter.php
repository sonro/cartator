<?php

namespace App\Infrastructure\Util\NameConverter;

use App\Core\Application\Util\NameConverter\CamelToSnakeNameConverterInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

final class SymfonyCameToSnakeNameConverterAdapter implements CamelToSnakeNameConverterInterface
{
    /**
     * @var CamelCaseToSnakeCaseNameConverter
     */
    private $converter;

    public function __construct()
    {
        $this->converter = new CamelCaseToSnakeCaseNameConverter(null, false);
    }

    public function normalize(string $input): string
    {
        return $this->converter->normalize($input);
    }

    public function denomalize(string $input): string
    {
        return $this->converter->denormalize($input);
    }
}
