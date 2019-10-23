<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;

class GetFromDictionaryDotComResult
{
    /**
     * @param \DOMDocument $result
     * @return Wotd
     * @throws InvalidDOMStructure
     * @throws WotdNotFound
     */
    public function parse(\DOMDocument $result): Wotd
    {
        $xpath           = new \DOMXPath($result);
        $wordNodes       = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' wotd-item__definition ')]");
        $definitionNodes = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' wotd-item__definition__text ')]");

        if ($definitionNodes->length === 0 || $wordNodes->length === 0) {
            throw new InvalidDOMStructure();
        }

        $word       = $wordNodes->item(0)->getElementsByTagName('h1')->item(0)->textContent;
        $url        = 'http://www.dictionary.com/browse/' . str_replace(' ', '-', $word);
        $definition = trim($definitionNodes->item(0)->textContent);

        if (strlen($word) === 0) {
            throw new WotdNotFound();
        }

        return new Wotd($word, $url, $definition);
    }
}
