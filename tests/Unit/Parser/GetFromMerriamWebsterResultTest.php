<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\ValueObject\Result;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromMerriamWebsterResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use PHPUnit\Framework\TestCase;
use function Room11\DOMUtils\domdocument_load_html;

class GetFromMerriamWebsterResultTest extends TestCase
{
    private GetFromMerriamWebsterResult $getFromMerriamWebsterResult;

    private Wotd $wotd;

    protected function setUp(): void
    {
        $this->getFromMerriamWebsterResult = new GetFromMerriamWebsterResult();
        $dom = domdocument_load_html('<div class=" word-header "><h1>Name</h1><div class=" wod-definition-container "><p><strong></strong>Description</p></div></div>');
        $this->wotd = $this->getFromMerriamWebsterResult->parse($dom);
    }

    public function testGetWord(): void
    {
        $this->assertSame('Name', $wotd->getWord());
    }

    public function testGetUrl(): void
    {
        $this->assertSame('http://www.dictionary.com/browse/Name', $wotd->getUrl());
    }

    public function testGetDefinition(): void
    {
        $this->assertSame('Description', $wotd->getDefinition());
    }

    public function testParseInvalidDOMStructure(): void
    {
        $this->expectException(InvalidDOMStructure::class);
        $this->expectExceptionMessage('Unexpected html structure');
        $dom = domdocument_load_html('');
        $wotd = $this->getFromMerriamWebsterResult->parse($dom);
    }

    public function testParseWotdNotFound(): void
    {
        $this->expectException(WotdNotFound::class);
        $this->expectExceptionMessage('WOTD not found');
        $dom = domdocument_load_html('<div class=" word-header "><h1></h1><div class=" wod-definition-container "><p><strong></strong>Description</p></div></div>');
        $wotd = $this->getFromMerriamWebsterResult->parse($dom);
    }
}
