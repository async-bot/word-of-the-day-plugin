<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Exception;

use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use PHPUnit\Framework\TestCase;

class WotdNotFoundTest extends TestCase
{
    public function testConstructorFormatsMessageCorrectly(): void
    {
        $this->expectException(WotdNotFound::class);
        $this->expectExceptionMessage('WOTD not found');

        throw new WotdNotFound();
    }
}
