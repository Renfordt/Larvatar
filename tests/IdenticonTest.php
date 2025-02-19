<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Identicon;
use Renfordt\Larvatar\Name;
use ReflectionException;
use TypeError;

#[CoversClass(Identicon::class)]
#[UsesClass(Name::class)]
class IdenticonTest extends TestCase
{
    /**
     * Tests the getSymmetryMatrix method to ensure it returns the expected symmetry matrix.
     */
    public function testGetSymmetryMatrixReturnedExpectedSymmetryMatrix(): void
    {
        // Mocking the Name class
        $name = Name::make('Test Name');

        // Creating Identicon
        $identicon = Identicon::make($name);

        // Set the number of pixels
        $identicon->setPixels(5);

        // Retrieve the symmetry matrix
        $symmetryMatrix = $this->invokeMethod($identicon, 'getSymmetryMatrix');

        // Define the expected matrix
        $expectedMatrix = [
            [0, 4],
            [1, 3],
            [2]
        ];

        // Assertion
        $this->assertEquals($expectedMatrix, $symmetryMatrix);
    }

    /**
     * Invokes a private or protected method on an object.
     *
     * @param object &$object Instantiated object to invoke the method on.
     * @param string $methodName Method name to invoke.
     * @param array $parameters Array of parameters to pass into the method.
     * @return mixed Method return.
     * @throws ReflectionException
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = []): mixed
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Tests the convertStrToBool method with the hexadecimal value '0'.
     */
    public function testConvertStrToBoolWithZero(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: Hex '0' should convert to boolean false
        $result = $this->invokeMethod($identicon, 'convertStrToBool', ['0']);
        $this->assertFalse($result);
    }

    /**
     * Tests the convertStrToBool method with the hexadecimal value 'F'.
     */
    public function testConvertStrToBoolWithF(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: Hex 'F' should convert to boolean true
        $result = $this->invokeMethod($identicon, 'convertStrToBool', ['F']);
        $this->assertTrue($result);
    }

    /**
     * Tests the convertStrToBool method with a mid-range hexadecimal value.
     */
    public function testConvertStrToBoolWithEight(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: Hex '8' should convert to boolean true
        $result = $this->invokeMethod($identicon, 'convertStrToBool', ['8']);
        $this->assertTrue($result);
    }

    /**
     * Tests the convertStrToBool method with a low-range hexadecimal value.
     */
    public function testConvertStrToBoolWithFour(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: Hex '4' should convert to boolean false
        $result = $this->invokeMethod($identicon, 'convertStrToBool', ['4']);
        $this->assertFalse($result);
    }

    /**
     * Tests the getSymmetryMatrix method to handle single pixel cases.
     */
    public function testGetSymmetryMatrixHandlesSinglePixel(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Set the number of pixels
        $identicon->setPixels(1);

        // Retrieve the symmetry matrix
        $symmetryMatrix = $this->invokeMethod($identicon, 'getSymmetryMatrix');

        // Define the expected matrix
        $expectedMatrix = [
            [0]
        ];

        // Assertion
        $this->assertEquals($expectedMatrix, $symmetryMatrix);
    }

    /**
     * Tests the getSymmetryMatrix method to handle even pixel counts.
     */
    public function testGetSymmetryMatrixHandlesEvenPixelCount(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Set the number of pixels
        $identicon->setPixels(6);

        // Retrieve the symmetry matrix
        $symmetryMatrix = $this->invokeMethod($identicon, 'getSymmetryMatrix');

        // Define the expected matrix
        $expectedMatrix = [
            [0, 5],
            [1, 4],
            [2, 3],
        ];

        // Assertion
        $this->assertEquals($expectedMatrix, $symmetryMatrix);
    }

    /**
     * Tests the getSVG method to ensure it returns a valid SVG representation with symmetry.
     */
    public function testGetSVGWithSymmetry(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon with symmetry
        $identicon = new Identicon($nameMock);
        $identicon->setSymmetry(true);

        // Assertion: Check if the output contains expected SVG structure
        $svgContent = $identicon->getSVG();
        $this->assertStringContainsString('<svg', $svgContent);
    }

    /**
     * Tests the getBase64 method to ensure it returns a base64 encoded SVG.
     */
    public function testGetBase64ReturnsBase64EncodedSVG(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Get the base64 encoded SVG
        $base64Content = $identicon->getBase64();

        // Assertion: Check if the output is properly base64 encoded
        $this->assertStringStartsWith('data:image/svg+xml;base64,', $base64Content);
        $this->assertTrue(base64_decode(substr($base64Content, 26)) !== false);
    }

    /**
     * Tests the getBase64 method to ensure it contains a valid SVG representation.
     */
    public function testGetBase64ContainsValidSVG(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Get the base64 encoded SVG
        $base64Content = $identicon->getBase64();

        // Decode base64 to get SVG content
        $svgContent = base64_decode(substr($base64Content, 26));

        // Assertion: Check if the decoded content contains expected SVG structure
        $this->assertStringContainsString('<svg', $svgContent);
    }

    /**
     * Tests the getSVG method to ensure it returns a valid SVG representation without symmetry.
     */
    public function testGetSVGWithoutSymmetry(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon without symmetry
        $identicon = new Identicon($nameMock);
        $identicon->setSymmetry(false);

        // Assertion: Check if the output contains expected SVG structure
        $svgContent = $identicon->getSVG();
        $this->assertStringContainsString('<svg', $svgContent);
    }

    /**
     * Tests the getSVG method to ensure the SVG output contains proper header.
     */
    public function testGetSVGHeader(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: Ensure the SVG header is valid
        $svgContent = $identicon->getSVG();
        $this->assertStringStartsWith('<?xml version="1.0" encoding="utf-8"?>', $svgContent);
    }

    /**
     * Tests if the Identicon object is created successfully with a valid Name object.
     * Also tests the static make method of Identicon class.
     */
    public function testConstructWithValidName(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertions
        $this->assertInstanceOf(Identicon::class, $identicon);
        $this->assertEquals($nameMock, $identicon->getName());
    }

    /**
     * Tests the setPixels method if it correctly sets the number of pixels.
     */
    public function testSetPixelsWithValidValue(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);
        $identicon->setPixels(10);

        // Assertion
        $this->assertEquals(10, $identicon->pixels);
    }

    /**
     * Tests the setPixels method with an invalid argument.
     *
     * @expectedException TypeError
     */
    public function testSetPixelsWithInvalidArgument(): void
    {
        $this->expectException(TypeError::class);

        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);
        $identicon->setPixels('invalid_value'); // Invalid argument
    }

    /**
     * Tests the make method with a valid Name object.
     */
    public function testMakeWithValidName(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon using the make method
        $identicon = Identicon::make($nameMock);

        // Assertions
        $this->assertInstanceOf(Identicon::class, $identicon);
        $this->assertEquals($nameMock, $identicon->getName());
    }

    /**
     * Tests the make method with an invalid argument.
     *
     */
    public function testMakeWithInvalidArgument(): void
    {
        $this->expectException(TypeError::class);

        // Creating Identicon with invalid argument using the make method
        Identicon::make('invalid_argument');
    }

    /**
     * Tests if the Identicon object throws an error when Name object is not provided.
     *
     */
    public function testConstructWithInvalidArgument(): void
    {
        $this->expectException(TypeError::class);

        // Creating Identicon with invalid argument
        new Identicon('invalid_argument');
    }

    /**
     * Tests the setSymmetry method if it correctly sets the symmetry to true.
     */
    public function testSetSymmetryWithTrueValue(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);
        $identicon->setSymmetry(true);

        // Use reflection to access the private property
        $reflection = new \ReflectionClass($identicon);
        $property = $reflection->getProperty('symmetry');
        $property->setAccessible(true);

        // Assertion
        $this->assertTrue($property->getValue($identicon));
    }

    /**
     * Tests the setSymmetry method if it correctly sets the symmetry to false.
     */
    public function testSetSymmetryWithFalseValue(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);
        $identicon->setSymmetry(false);

        // Use reflection to access the private property
        $reflection = new \ReflectionClass($identicon);
        $property = $reflection->getProperty('symmetry');
        $property->setAccessible(true);

        // Assertion
        $this->assertFalse($property->getValue($identicon));
    }

    /**
     * Tests the setSymmetry method with an invalid argument.
     *
     */
    public function testSetSymmetryWithInvalidArgument(): void
    {
        $this->expectException(TypeError::class);

        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);
        $identicon->setSymmetry('invalid_value'); // Invalid argument
    }

    /**
     * Tests the getHTML method without base64 encoding.
     */
    public function testGetHTMLWithoutBase64(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: ensure the output is SVG
        $this->assertStringContainsString('<svg', $identicon->getHTML(false));
    }

    /**
     * Tests the getHTML method with base64 encoding.
     */
    public function testGetHTMLWithBase64(): void
    {
        // Mocking the Name class
        $nameMock = $this->createMock(Name::class);

        // Creating Identicon
        $identicon = new Identicon($nameMock);

        // Assertion: ensure the output is base64 encoded image
        $this->assertStringContainsString('<img src="data:image/svg+xml;base64,', $identicon->getHTML(true));
    }

    /**
     * Tests the generateSymmetricMatrix method to ensure it returns a symmetric matrix.
     */
    public function testGenerateSymmetricMatrix(): void
    {
        // Mocking the Name class
        $name = Name::make('Test Name');

        // Creating Identicon
        $identicon = new Identicon($name);

        // Generate symmetric matrix
        $matrix = $identicon->generateSymmetricMatrix();

        // Assert matrix is symmetric
        $this->assertIsArray($matrix);
        foreach ($matrix as $row) {
            $this->assertIsArray($row);
        }
        // ToDo: Test actual values
    }

    /**
     * Tests the generateSymmetricMatrix method with different pixel values.
     */
    public function testGenerateSymmetricMatrixWithDifferentPixelValues(): void
    {
        // Mocking the Name class
        $name = Name::make('Test Name');

        $pixelValues = [3, 5, 7];

        foreach ($pixelValues as $pixels) {
            // Creating Identicon with different pixel values
            $identicon = new Identicon($name);
            $identicon->setPixels($pixels);

            // Generate symmetric matrix
            $matrix = $identicon->generateSymmetricMatrix();

            // Assert matrix dimensions
            $this->assertIsArray($matrix);
            // ToDo: add real value tests
        }
    }

    /**
     * Tests the generateSymmetricMatrix method with variation in Name hashes.
     */
    public function testGenerateSymmetricMatrixWithNameHashVariation(): void
    {
        $hashes = [
            'aabbccddeeff001122334455',
            '111122223333444455556666',
            '999988887777666655554444'
        ];

        foreach ($hashes as $hash) {
            // Mocking the Name class
            $nameMock = $this->createMock(Name::class);
            $nameMock->method('getHash')->willReturn($hash);

            // Creating Identicon
            $identicon = new Identicon($nameMock);

            // Generate symmetric matrix
            $matrix = $identicon->generateSymmetricMatrix();

            // Assert matrix is symmetric
            $this->assertIsArray($matrix);
            foreach ($matrix as $row) {
                $this->assertIsArray($row);
            }
            //todo: add real value tests
        }
    }


}
