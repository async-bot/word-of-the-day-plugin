<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\Parser\ParseDictionaryDotComResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use PHPUnit\Framework\TestCase;
use function Room11\DOMUtils\domdocument_load_html;

class ParseDictionaryDotComResultTest extends TestCase
{
    public function testGetWordThrowsWhenWordOfTheDayContainerIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word of the day" element on the page');

        (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-word-of-the-day-container.html'),
            ),
        );
    }

    public function testGetWordThrowsWhenWordOfTheDayIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word of the day" element on the page');

        (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-word-of-the-day.html'),
            ),
        );
    }

    public function testGetWord(): void
    {
        $wordOfTheDay = (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('foison', $wordOfTheDay->getWord());
    }

    public function testGetUrlThrowsWhenUrlIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "url" element on the page');

        (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-url.html'),
            ),
        );
    }

    public function testGetUrl(): void
    {
        $wordOfTheDay = (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('https://www.dictionary.com/browse/foison', $wordOfTheDay->getUrl());
    }

    public function testGetDefinitionThrowsWhenDefinitionIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "definition" element on the page');

        (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-definition.html'),
            ),
        );
    }

    public function testGetDefinition(): void
    {
        $wordOfTheDay = (new ParseDictionaryDotComResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('abundance; plenty.', $wordOfTheDay->getDefinition());
    }
}
