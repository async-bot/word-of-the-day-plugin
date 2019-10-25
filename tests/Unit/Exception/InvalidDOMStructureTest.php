<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Exception;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use PHPUnit\Framework\TestCase;

class InvalidDOMStructureTest extends TestCase
{
    public function testConstructorFormatsMessageCorrectly(): void
    {
        $this->expectException(InvalidDOMStructure::class);
        $this->expectExceptionMessage('Unexpected html structure');

        throw new InvalidDOMStructure();
    }
}
