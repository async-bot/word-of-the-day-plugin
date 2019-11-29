<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Exception;

use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use PHPUnit\Framework\TestCase;

class UnexpectedHtmlFormatTest extends TestCase
{
    public function testConstructorFormatsMessageCorrectly(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "TEST" element on the page');

        throw new UnexpectedHtmlFormat('TEST');
    }
}
