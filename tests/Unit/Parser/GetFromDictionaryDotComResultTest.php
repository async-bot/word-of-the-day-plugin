<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromDictionaryDotComResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use PHPUnit\Framework\TestCase;

class GetFromDictionaryDotComResultTest extends TestCase
{
    private GetFromDictionaryDotComResult $getFromDictionaryDotComResult;

    protected function setUp(): void
    {
        $this->getFromDictionaryDotComResult = new GetFromDictionaryDotComResult();
    }

    public function testParse(): void
    {
        $dom = new \DOMDocument();
        $dom->loadHTML('<div class=" wotd-item__definition "><h1>Name</h1><div class=" wotd-item__definition__text ">Description</div></div>');
        $wotd = $this->getFromDictionaryDotComResult->parse($dom);
        $this->assertInstanceOf(Wotd::class, $wotd);
        $this->assertSame('Name', $wotd->getWord());
        $this->assertSame('http://www.dictionary.com/browse/Name', $wotd->getUrl());
        $this->assertSame('Description', $wotd->getDefinition());
    }

    public function testParseInvalidDOMStructure(): void
    {
        $this->expectException(InvalidDOMStructure::class);
        $this->expectExceptionMessage('Unexpected html structure');
        $dom  = new \DOMDocument();
        $wotd = $this->getFromDictionaryDotComResult->parse($dom);
    }

    public function testParseWotdNotFound(): void
    {
        $this->expectException(WotdNotFound::class);
        $this->expectExceptionMessage('WOTD not found');
        $dom = new \DOMDocument();
        $dom->loadHTML('<div class=" wotd-item__definition "><h1></h1><div class=" wotd-item__definition__text ">Description</div></div>');
        $wotd = $this->getFromDictionaryDotComResult->parse($dom);
    }
}