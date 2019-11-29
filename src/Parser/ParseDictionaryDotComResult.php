<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use function Room11\DOMUtils\xpath_html_class;

class ParseDictionaryDotComResult
{
    /**
     * @throws UnexpectedHtmlFormat
     */
    public function parse(\DOMDocument $domDocument): WordOfTheDay
    {
        $xpath = new \DOMXPath($domDocument);

        return new WordOfTheDay(
            $this->getWord($xpath),
            $this->getUrl($xpath),
            $this->getDefinition($xpath),
        );
    }

    /**
     * @throws UnexpectedHtmlFormat
     */
    private function getWord(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $wordNode */
        $wordNode = $xpath->evaluate('(//*[' . xpath_html_class('wotd-item__definition') . '])[1]/h1');

        if ($wordNode->length !== 1) {
            throw new UnexpectedHtmlFormat('word of the day');
        }

        return trim($wordNode->item(0)->textContent);
    }

    /**
     * @throws UnexpectedHtmlFormat
     */
    private function getUrl(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $urlNode */
        $urlNode = $xpath->evaluate('(//*[' . xpath_html_class('wotd-item__definition') . '])[1]/a[2]');

        if ($urlNode->length !== 1) {
            throw new UnexpectedHtmlFormat('url');
        }

        return trim($urlNode->item(0)->getAttribute('href'));
    }

    /**
     * @throws UnexpectedHtmlFormat
     */
    private function getDefinition(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $definitionNodes */
        $definitionNodes = $xpath->evaluate('//*[' . xpath_html_class('wotd-item__definition__text') . ']');

        if (!$definitionNodes->length) {
            throw new UnexpectedHtmlFormat('definition');
        }

        return trim($definitionNodes->item(0)->textContent);
    }
}
