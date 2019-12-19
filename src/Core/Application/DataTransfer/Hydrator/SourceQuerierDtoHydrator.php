<?php

namespace App\Core\Application\DataTransfer\Hydrator;

use App\Core\Application\DataTransfer\Dto\SourceQuerierDto;
use App\Core\Application\SourceAccess\SourceQuery\SourceQueryInterface;
use App\Core\Application\Util\NameConverter\CamelToSnakeNameConverterInterface;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\SourceAccess\Model\DataType\DataType;
use App\Core\Domain\SourceAccess\Model\Shared\AccessorMethod;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;

final class SourceQuerierDtoHydrator
{
    /**
     * @var CamelToSnakeNameConverterInterface
     */
    private $nameConverter;

    public function __construct(CamelToSnakeNameConverterInterface $converter)
    {
        $this->nameConverter = $converter;
    }

    public function hydrateFromModel(SourceQuerier $sourceQuerier): SourceQuerierDto
    {
        $className = $sourceQuerier->getClassName();
        $interfaceName = $sourceQuerier->getInterfaceName()();
        $methodName = $sourceQuerier->getMethod()->getName();
        $sourceAppName = $sourceQuerier->getSourceApp()->getName();
        $dataTypeName = $sourceQuerier->getDataType()->getName();

        return new SourceQuerierDto(
            $className,
            $interfaceName,
            $methodName,
            $sourceAppName,
            $dataTypeName
        );
    }

    // public function hydrateModel(
    //     SourceQuerierDto $sourceQuerierDto,
    //     ?DataType $dataType = null,
    //     ?SourceApp $sourceApp = null
    // ): SourceQuerier {
    //     if ($dataType === null) {
    //         // TODO: Fetch datatype using dto
    //     }

    //     if ($sourceApp === null) {
    //         // TODO: Fetch sourceapp using dto
    //     }

    //     $sourceQuerier = new SourceQuerier();
    //     $sourceQuerier->setMethod(new AccessorMethod($sourceQuerierDto->getMethodName()));
    //     $sourceQuerier->setClassName($sourceQuerierDto->getClassName());
    //     $sourceQuerier->setInterfaceName($sourceQuerierDto->getInterfaceName());
    //     $sourceQuerier->setDataType($dataType);
    //     $sourceQuerier->setSourceApp($sourceApp);

    //     return $sourceQuerier;
    // }

    public function createFromClassName(string $className): ?SourceQuerierDto
    {
        $interfaces = class_implements($className);
        if (isset($interfaces[SourceQueryInterface::class])) {
            unset($interfaces[SourceQueryInterface::class]);
        } else {
            return null;
        }

        $namespaces = explode('\\', $className);
        $nsIndex = array_search('SourceQuery', $namespaces) + 1;
        $namespaces = array_splice($namespaces, $nsIndex);

        $methodName = $this->nameConverter->normalize($namespaces[0]);
        $sourceAppName = $this->nameConverter->normalize($namespaces[1]);
        $dataTypeName = $this->nameConverter->normalize($namespaces[2]);

        if (count($interfaces) > 1) {
            $shortClassName = end($namespaces);
            if ($shortClassName === false) {
                return null;
            }
            $expectedInterfaceName = $shortClassName.'Interface';
            foreach ($interfaces as $interface) {
                $interfaceNamespaces = explode('\\', $interface);
                $shortInterfaceName = end($interfaceNamespaces);
                if ($shortInterfaceName === $expectedInterfaceName) {
                    $interfaceName = $interface;
                }
            }
            if (!isset($interfaceName)) {
                return null;
            }
        } else {
            $interfaceName = array_shift($interfaces);
            if ($interfaceName === null) {
                return null;
            }
        }

        return new SourceQuerierDto(
            $className,
            $interfaceName,
            $methodName,
            $sourceAppName,
            $dataTypeName
        );
    }
}
