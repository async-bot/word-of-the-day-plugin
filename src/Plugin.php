<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Exception\WordOfTheDayNotFound;
use AsyncBot\Plugin\WordOfTheDay\Retriever\GetFromDictionaryDotCom;
use AsyncBot\Plugin\WordOfTheDay\Retriever\GetFromMerriamWebster;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;

final class Plugin
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
    public function getFromDictionaryDotCom(): Promise
    {
        return (new GetFromDictionaryDotCom($this->httpClient))->retrieve();
    }

    /**
     * @return Promise<WordOfTheDay>
     * @throws WordOfTheDayNotFound
     */
    public function getFromMerriamWebster(): Promise
    {
        return (new GetFromMerriamWebster($this->httpClient))->retrieve();
    }
}
