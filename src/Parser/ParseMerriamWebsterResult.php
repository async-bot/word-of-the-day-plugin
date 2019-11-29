<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use function Room11\DOMUtils\xpath_html_class;

class ParseMerriamWebsterResult
{
    private const WORD_URL = 'https://www.merriam-webster.com/dictionary/%s';

    /**
     * @throws UnexpectedHtmlFormat
     */
    public function parse(\DOMDocument $domDocument): WordOfTheDay
    {
        $xpath = new \DOMXPath($domDocument);

        $word = $this->getWord($xpath);

        return new WordOfTheDay(
            $word,
            $this->getUrl($word),
            $this->getDefinition($xpath),
        );
    }

    /**
     * @throws UnexpectedHtmlFormat
     */
    private function getWord(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $wordNode */
        $wordNode = $xpath->evaluate('(//*[' . xpath_html_class('word-header') . '])//h1[1]');

        if ($wordNode->length !== 1) {
            throw new UnexpectedHtmlFormat('word of the day');
        }

        return trim($wordNode->item(0)->textContent);
    }

    private function getUrl(string $word): string
    {
        return sprintf(self::WORD_URL, str_replace(' ', '-', $word));
    }

    /**
     * @throws UnexpectedHtmlFormat
     */
    private function getDefinition(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $wordDefinitionContainerNode */
        $wordDefinitionContainerNode = $xpath->evaluate('(//*[' . xpath_html_class('wod-definition-container') . '])[1]');

        if ($wordDefinitionContainerNode->length !== 1) {
            throw new UnexpectedHtmlFormat('word definition container');
        }

        /** @var \DOMNodeList $wordDefinitionNodes */
        $wordDefinitionNodes = $wordDefinitionContainerNode->item(0)->getElementsByTagName('p');

        if ($wordDefinitionNodes->length === 0) {
            throw new UnexpectedHtmlFormat('word definition');
        }

        return trim($wordDefinitionNodes->item(0)->textContent);
    }
}
