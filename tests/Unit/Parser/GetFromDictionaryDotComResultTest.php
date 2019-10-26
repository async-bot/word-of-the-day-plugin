<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromDictionaryDotComResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use PHPUnit\Framework\TestCase;
use function Room11\DOMUtils\domdocument_load_html;

class GetFromDictionaryDotComResultTest extends TestCase
{
    private GetFromDictionaryDotComResult $getFromDictionaryDotComResult;

    private Wotd $wotd;

    protected function setUp(): void
    {
        $this->getFromDictionaryDotComResult = new GetFromDictionaryDotComResult();
        $dom = domdocument_load_html('<div class=" wotd-item__definition "><h1>Name</h1><div class=" wotd-item__definition__text ">Description</div></div>');
        $this->wotd = $this->getFromDictionaryDotComResult->parse($dom);
    }

    public function testGetWord(): void
    {
        $this->assertSame('Name', $this->wotd->getWord());
    }

    public function testGetUrl(): void
    {
        $this->assertSame('http://www.dictionary.com/browse/Name', $this->wotd->getUrl());
    }

    public function testGetDefinition(): void
    {
        $this->assertSame('Description', $this->wotd->getDefinition());
    }

    public function testParseInvalidDOMStructure(): void
    {
        $this->expectException(InvalidDOMStructure::class);
        $this->expectExceptionMessage('Unexpected html structure');
        $dom = domdocument_load_html('');
        $wotd = $this->getFromDictionaryDotComResult->parse($dom);
    }

    public function testParseWotdNotFound(): void
    {
        $this->expectException(WotdNotFound::class);
        $this->expectExceptionMessage('WOTD not found');
        $dom = domdocument_load_html('<div class=" wotd-item__definition "><h1></h1><div class=" wotd-item__definition__text ">Description</div></div>');
        $wotd = $this->getFromDictionaryDotComResult->parse($dom);
    }
}
