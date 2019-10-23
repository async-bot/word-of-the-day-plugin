<?php
declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Retriever;

use Amp\Http\Client\Response;
use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Exception\WotdNotFound;
use AsyncBot\Plugin\WordOfTheDay\Parser\GetFromDictionaryDotComResult;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\Wotd;
use function Amp\call;

final class GetFromDictionaryDotCom
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
            return (new GetFromDictionaryDotComResult())->parse(
            /** @var Response $response */
                yield $this->httpClient->requestHtml('http://www.dictionary.com/wordoftheday/'));
        });
    }
}