<?php

namespace App\Core\Application\Util\Encoder;

interface SensitiveStringEncoderInterface
{
    /**
     * Encode a sensitive string to be stored.
     *
     * @param string $input
     *
     * @return string
     */
    public function encode(string $input): string;

    /**
     * Decode a string from storage to display.
     *
     * @param string $input
     *
     * @return string
     */
    public function decode(string $input): string;
}
