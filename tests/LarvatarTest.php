<?php

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

class LarvatarTest extends TestCase
{
    public function testCreateLarvatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::InitialsAvatar);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarWithInt(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', 0);
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarException(): void
    {
        $this->expectError(ValueError::class);
        $larvatar = new Larvatar('Test Name', 'test@example.com', 700);
    }

    public function testSetFont(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::InitialsAvatar);
        $larvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #9c3564" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-family: Roboto; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateGravatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::Gravatar);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMp(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::mp);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=mp&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateIdenticon(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::identicon);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=identicon&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMonsterid(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::monsterid);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=monsterid&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateWavatar(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::wavatar);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=wavatar&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRetro(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::retro);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=retro&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRobohash(): void
    {
        $larvatar = new Larvatar('Test Name', 'test@example.com', LarvatarTypes::robohash);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=robohash&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

}