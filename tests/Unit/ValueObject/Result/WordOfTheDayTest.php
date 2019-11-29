<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use PHPUnit\Framework\TestCase;

class WordOfTheDayTest extends TestCase
{
    private WordOfTheDay $wordOfTheDay;

    protected function setUp(): void
    {
        $this->wordOfTheDay = new WordOfTheDay(
            'Noachian',
            'https://www.merriam-webster.com/dictionary/Noachian',
            'of or relating to the patriarch Noah or his time',
        );
    }

    public function testGetWord(): void
    {
        $this->assertSame('Noachian', $this->wordOfTheDay->getWord());
    }

    public function testGetUrl(): void
    {
        $this->assertSame(
            'https://www.merriam-webster.com/dictionary/Noachian',
            $this->wordOfTheDay->getUrl(),
        );
    }

    public function testGetDefinition(): void
    {
        $this->assertSame(
            'of or relating to the patriarch Noah or his time',
            $this->wordOfTheDay->getDefinition(),
        );
    }
}
