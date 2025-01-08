<?php

declare(strict_types=1);

namespace Traits;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Avatar;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Gravatar;
use Renfordt\Larvatar\Identicon;
use Renfordt\Larvatar\InitialsAvatar;
use Renfordt\Larvatar\Larvatar;
use Renfordt\Larvatar\Name;
use Renfordt\Larvatar\Traits\ColorTrait;
use Renfordt\Larvatar\Traits\LarvatarTrait;

#[CoversClass(LarvatarTrait::class)]
#[UsesClass(Avatar::class)]
#[UsesClass(InitialsAvatar::class)]
#[UsesClass(Identicon::class)]
#[UsesClass(Larvatar::class)]
#[UsesClass(Name::class)]
#[UsesClass(ColorTrait::class)]
#[UsesClass(Gravatar::class)]
class LarvatarTraitTest extends TestCase
{
    use LarvatarTrait;

    private string $name = 'Test Name';
    private string $email = 'test@test.com';
    private LarvatarTypes $type = LarvatarTypes::InitialsAvatar;

    public static function dataProviderForGetAvatarTest(): array
    {
        return [
            [
                'Test Name',
                'test@test.com',
                100,
                LarvatarTypes::InitialsAvatar,
                true,
                '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI1MCIgc3R5bGU9ImZpbGw6ICNlNWIzYzkiIC8+PHRleHQgeD0iNTAlIiB5PSI1NSUiIHN0eWxlPSJmaWxsOiAjODUyZDU1OyB0ZXh0LWFuY2hvcjogbWlkZGxlOyBkb21pbmFudC1iYXNlbGluZTogbWlkZGxlOyBmb250LXdlaWdodDogbm9ybWFsOyBmb250LWZhbWlseTogU2Vnb2UgVUksIEhlbHZldGljYSwgc2Fucy1zZXJpZjsgZm9udC1zaXplOiA1MHB4Ij5UTjwvdGV4dD48L3N2Zz4=" />'
            ],
            // additional cases...
        ];
    }

    public static function dataProviderForDifferentAvatarTypes(): array
    {
        return [
            [LarvatarTypes::InitialsAvatar],
            [LarvatarTypes::Gravatar],
            [LarvatarTypes::IdenticonLarvatar],
            // add other types if any...
        ];
    }

    // New test cases

    public static function dataProviderForEncodingVariations(): array
    {
        return [
            [true],
            [false],
        ];
    }

    #[DataProvider('dataProviderForGetAvatarTest')]
    public function testGetAvatar(
        string $name,
        string $email,
        int $size,
        LarvatarTypes $type,
        bool $encoding,
        string $expectedData
    ): void {
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $result = $this->getAvatar($size, $encoding);
        $this->assertSame($expectedData, $result);
    }

    public function getAvatar(int $size = 100, bool $encoding = true): string
    {
        $larvatar = $this->getLarvatar($this->name, $this->email, $this->type);
        $larvatar->setSize($size);
        $larvatar->setWeight('normal');
        return $larvatar->getImageHTML($encoding);
    }

    public function testGetAvatarWithDefaultParameters(): void
    {
        $result = $this->getAvatar();
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForDifferentAvatarTypes')]
    public function testGetAvatarWithDifferentAvatarTypes(LarvatarTypes $type): void
    {
        $this->type = $type;
        $result = $this->getAvatar(100, false);
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForEncodingVariations')]
    public function testGetAvatarWithEncodingVariations(bool $encoding): void
    {
        $result = $this->getAvatar(100, $encoding);
        $this->assertNotEmpty($result);
    }
}
