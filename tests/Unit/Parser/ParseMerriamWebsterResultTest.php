<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\Parser\ParseMerriamWebsterResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use PHPUnit\Framework\TestCase;
use function Room11\DOMUtils\domdocument_load_html;

class ParseMerriamWebsterResultTest extends TestCase
{
    public function testGetWordThrowsWhenWordOfTheDayContainerIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word of the day" element on the page');

        (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-word-of-the-day-container.html'),
            ),
        );
    }

    public function testGetWordThrowsWhenWordOfTheDayIsMissing(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word of the day" element on the page');

        (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/missing-word-of-the-day.html'),
            ),
        );
    }

    public function testGetWord(): void
    {
        $wordOfTheDay = (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('comestible', $wordOfTheDay->getWord());
    }

    public function testGetUrl(): void
    {
        $wordOfTheDay = (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('https://www.merriam-webster.com/dictionary/comestible', $wordOfTheDay->getUrl());
    }

    public function testGetUrlReplacesSpacesWithDashes(): void
    {
        $wordOfTheDay = (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/valid-with-spaces-in-word-of-the-day.html'),
            ),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame('https://www.merriam-webster.com/dictionary/come-stible', $wordOfTheDay->getUrl());
    }

    public function testGetDefinitionThrowsOnMissingDefinitionContainer(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word definition container" element on the page');

        (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/missing-definition-container.html'),
            ),
        );
    }

    public function testGetDefinitionThrowsOnMissingDefinition(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "word definition" element on the page');

        (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(
                file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/missing-definition.html'),
            ),
        );
    }

    public function testGetDefinition(): void
    {
        $wordOfTheDay = (new ParseMerriamWebsterResult())->parse(
            domdocument_load_html(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/MerriamWebster/valid.html')),
        );

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
        $this->assertSame(': edible', $wordOfTheDay->getDefinition());
    }
}
