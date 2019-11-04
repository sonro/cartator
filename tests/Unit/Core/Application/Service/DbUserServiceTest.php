<?php

namespace App\Unit\Core\Application\Service;

use App\Core\Application\Service\DbUserService;
use App\Core\Application\Util\Encoder\SensitiveStringEncoder;
use App\Core\Domain\Resource\Model\SourceDb\DbHost;
use App\Core\Domain\Resource\Model\SourceDb\DbUser;
use PHPUnit\Framework\TestCase;

final class DbUserServiceTest extends TestCase
{
    private static $key = 'test';

    /**
     * @var DbUserService;
     */
    private $dbUserService;

    /**
     * @var SensitiveStringEncoder
     */
    private $encoder;

    protected function setUp()
    {
        $this->encoder = new SensitiveStringEncoder(self::$key);
        $this->dbUserService = new DbUserService(
            new SensitiveStringEncoder(self::$key)
        );
    }

    public function testGetPlainUsername()
    {
        $plainPasswordInput = 'testPassword';
        $plainUsernameInput = 'testUsername';

        $dbHost = new DbHost();
        $dbHost->setAddress('127.0.0.1');

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);
        $dbUser->setPassword($this->encoder->encode($plainPasswordInput));
        $dbUser->setUsername($this->encoder->encode($plainUsernameInput));

        $this->assertNotEquals($plainUsernameInput, $dbUser->getUsername());

        $plainUsernameOutput = $this->dbUserService->getPlainUsername($dbUser);
        $this->assertEquals($plainUsernameInput, $plainUsernameOutput);
    }

    public function testGetPlainPassword()
    {
        $plainPasswordInput = 'testPassword';
        $plainUsernameInput = 'testUsername';

        $dbHost = new DbHost();
        $dbHost->setAddress('127.0.0.1');

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);
        $dbUser->setPassword($this->encoder->encode($plainPasswordInput));
        $dbUser->setUsername($this->encoder->encode($plainUsernameInput));

        $this->assertNotEquals($plainPasswordInput, $dbUser->getPassword());

        $plainPasswordOutput = $this->dbUserService->getPlainPassword($dbUser);
        $this->assertEquals($plainPasswordInput, $plainPasswordOutput);
    }

    public function testEncodePassword()
    {
        $plainPasswordInput = 'testPassword';
        $plainUsernameInput = 'testUsername';

        $dbHost = new DbHost();
        $dbHost->setAddress('127.0.0.1');

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);

        $this->dbUserService->encodePassword($dbUser, $plainPasswordInput);
        $this->dbUserService->encodeUsername($dbUser, $plainUsernameInput);

        $this->assertNotEquals($plainPasswordInput, $dbUser->getPassword());
        $plainPasswordOutput = $this->encoder->decode($dbUser->getPassword());
        $this->assertEquals($plainPasswordInput, $plainPasswordOutput);
    }

    public function testEncodeUsername()
    {
        $plainPasswordInput = 'testPassword';
        $plainUsernameInput = 'testUsername';

        $dbHost = new DbHost();
        $dbHost->setAddress('127.0.0.1');

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);

        $this->dbUserService->encodePassword($dbUser, $plainPasswordInput);
        $this->dbUserService->encodeUsername($dbUser, $plainUsernameInput);

        $this->assertNotEquals($plainUsernameInput, $dbUser->getUsername());
        $plainUsernameOutput = $this->encoder->decode($dbUser->getUsername());
        $this->assertEquals($plainUsernameInput, $plainUsernameOutput);
    }
}
