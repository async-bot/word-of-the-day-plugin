<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\WordOfTheDay\Exception\WordOfTheDayNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\ParseMerriamWebsterResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use function Amp\call;

final class GetFromMerriamWebster
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
                return (new ParseMerriamWebsterResult())->parse(
                    yield $this->httpClient->requestHtml('https://www.merriam-webster.com/word-of-the-day'),
                );
            } catch (UnexpectedHtmlFormat $e) {
                throw new WordOfTheDayNotFound();
            }
        });
    }
}
