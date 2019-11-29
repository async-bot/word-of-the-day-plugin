<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Exception;

use AsyncBot\Plugin\WordOfTheDay\Exception\WordOfTheDayNotFound;
use PHPUnit\Framework\TestCase;

class WordOfTheDayNotFoundTest extends TestCase
{
    public function testConstructorFormatsMessageCorrectly(): void
    {
        $this->expectException(WordOfTheDayNotFound::class);
        $this->expectExceptionMessage('Could not find the Word of the Day');

        throw new WordOfTheDayNotFound();
    }
}
