<?php
declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Parser;

use AsyncBot\Plugin\WordOfTheDay\Exception\InvalidDOMStructure;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;

class GetFromMerriamWebsterResult
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
        $wordNodes       = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' word-header ')]");
        $definitionNodes = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' wod-definition-container ')]");

        if ($definitionNodes->length === 0 || $wordNodes->length === 0) {
            throw new InvalidDOMStructure();
        }

        $definitionBullet = $definitionNodes->item(0)->getElementsByTagName('p')->item(0)->getElementsByTagName('strong')->item(0);
        $definitionNodes->item(0)->getElementsByTagName('p')->item(0)->removeChild($definitionBullet);

        $word       = $wordNodes->item(0)->getElementsByTagName('h1')->item(0)->textContent;
        $url        = 'https://www.merriam-webster.com/dictionary/' . str_replace(' ', '-', $word);
        $definition = $definitionNodes->item(0)->getElementsByTagName('p')->item(0)->textContent;

        if (strlen($word) === 0) {
            throw new WotdNotFound();
        }

        return new Wotd($word, $url, $definition);
    }
}