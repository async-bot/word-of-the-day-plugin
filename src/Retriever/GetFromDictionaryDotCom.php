<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\Exception\WordOfTheDayNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\ParseDictionaryDotComResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use function Amp\call;

final class GetFromDictionaryDotCom
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Promise<WordOfTheDay>
     * @throws WordOfTheDayNotFound
     */
    public function retrieve(): Promise
    {
        return call(function () {
            try {
                return (new ParseDictionaryDotComResult())->parse(
                    yield $this->httpClient->requestHtml('http://www.dictionary.com/wordoftheday/'),
                );
            } catch (UnexpectedHtmlFormat $e) {
                throw new WordOfTheDayNotFound();
            }
        });
    }
}
