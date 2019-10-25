<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromMerriamWebsterResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use PHPUnit\Framework\TestCase;

class GetFromMerriamWebsterResultTest extends TestCase
{
    private GetFromMerriamWebsterResult $getFromMerriamWebsterResult;

    protected function setUp(): void
    {
        $this->getFromMerriamWebsterResult = new GetFromMerriamWebsterResult();
    }

    public function testParse(): void
    {
        $dom = new \DOMDocument();
        $dom->loadHTML('<div class=" word-header "><h1>Name</h1><div class=" wod-definition-container "><p><strong></strong>Description</p></div></div>');
        $wotd = $this->getFromMerriamWebsterResult->parse($dom);
        $this->assertInstanceOf(Wotd::class, $wotd);
        $this->assertSame('Name', $wotd->getWord());
        $this->assertSame('https://www.merriam-webster.com/dictionary/Name', $wotd->getUrl());
        $this->assertSame('Description', $wotd->getDefinition());
    }

    public function testParseInvalidDOMStructure(): void
    {
        $this->expectException(InvalidDOMStructure::class);
        $this->expectExceptionMessage('Unexpected html structure');
        $dom  = new \DOMDocument();
        $wotd = $this->getFromMerriamWebsterResult->parse($dom);
    }

    public function testParseWotdNotFound(): void
    {
        $this->expectException(WotdNotFound::class);
        $this->expectExceptionMessage('WOTD not found');
        $dom = new \DOMDocument();
        $dom->loadHTML('<div class=" word-header "><h1></h1><div class=" wod-definition-container "><p><strong></strong>Description</p></div></div>');
        $wotd = $this->getFromMerriamWebsterResult->parse($dom);
    }
}
