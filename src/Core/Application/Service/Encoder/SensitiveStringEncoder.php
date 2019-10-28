<?php

namespace App\Core\Application\Service\Encoder;

use Exception;

final class SensitiveStringEncoder implements SensitiveStringEncoderInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $seperator;

    public function __construct(string $key)
    {
        $this->seperator = '::';
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(string $input): string
    {
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using
        // the encryption key key and initialization vector
        $encrypted = openssl_encrypt($input, 'aes-256-cbc', $this->key, 0, $iv);
        // the $iv is as important as the key for decrypting, so save it with
        // the encrypted data using a unique seperator (::)
        return base64_encode($encrypted.$this->seperator.$iv);
    }

    /**
     * {@inheritdoc}
     */
    public function decode(string $input): string
    {
        // To decrypt, split the encrypted data from the IV the unique seperator was '::'
        try {
            list($encryptedData, $iv) = explode($this->seperator, base64_decode($input), 2);
        } catch (Exception $e) {
            throw new Exception(
                'Unable to split encoded string into data and iv: '
                .$e->getMessage()
            );
        }

        return openssl_decrypt($encryptedData, 'aes-256-cbc', $this->key, 0, $iv);
    }
}
