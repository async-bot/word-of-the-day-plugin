<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use PHPUnit\Framework\TestCase;

class WotdTest extends TestCase
{
    private Wotd $wotd;

    protected function setUp(): void
    {
        $this->wotd = new Wotd("Noachian", "https://www.merriam-webster.com/dictionary/Noachian", "of or relating to the patriarch Noah or his time");
    }

    public function testGetWord(): void
    {
        $this->assertSame("Noachian", $this->wotd->getWord());
    }

    public function testGetUrl(): void
    {
        $this->assertSame("https://www.merriam-webster.com/dictionary/Noachian", $this->wotd->getUrl());
    }

    public function testGetDefinition(): void
    {
        $this->assertSame("of or relating to the patriarch Noah or his time", $this->wotd->getDefinition());
    }
}
