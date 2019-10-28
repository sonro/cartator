<?php

namespace App\Unit\Core\Application\Service\Encoder;

use App\Core\Application\Service\Encoder\SensitiveStringEncoder;
use PHPUnit\Framework\TestCase;

final class SensitiveStringEncoderTest extends TestCase
{
    protected static $key = 'test';

    public function testEncodeAndDecode()
    {
        $encoder = new SensitiveStringEncoder(self::$key);
        $testInput = 'CheckingThis75!string';

        $encodedOutput = $encoder->encode($testInput);
        $this->assertNotEquals($testInput, $encodedOutput);

        $decodedOutput = $encoder->decode($encodedOutput);
        $this->assertNotEquals($encodedOutput, $decodedOutput);
        $this->assertEquals($testInput, $decodedOutput);
    }

    public function testDifferentEncoderAndDecoder()
    {
        $encoder = new SensitiveStringEncoder(self::$key);
        $decoder = new SensitiveStringEncoder(self::$key);
        $testInput = 'CheckingT\'qhis75!string';

        $encodedOutput = $encoder->encode($testInput);
        $this->assertNotEquals($testInput, $encodedOutput);

        $decodedOutput = $decoder->decode($encodedOutput);
        $this->assertNotEquals($encodedOutput, $decodedOutput);
        $this->assertEquals($testInput, $decodedOutput);
    }
}
