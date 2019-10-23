<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Retriever;

use Amp\Http\Client\Response;
use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromMerriamWebsterResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use function Amp\call;

final class GetFromMerriamWebster
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Promise<Wotd>
     * @throws WotdNotFound
     */
    public function retrieve(): Promise
    {
        return call(function () {
            return (new GetFromMerriamWebsterResult())->parse(
            /** @var Response $response */
                yield $this->httpClient->requestHtml('https://www.merriam-webster.com/word-of-the-day'));
        });
    }
}
