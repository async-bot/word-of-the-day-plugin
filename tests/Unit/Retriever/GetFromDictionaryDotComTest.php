<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDayTest\Unit\Retriever;

use Amp\Http\Client\HttpClientBuilder;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\WordOfTheDay\Retriever\GetFromDictionaryDotCom;
use AsyncBot\Plugin\WordOfTheDay\ValueObject\Result\WordOfTheDay;
use AsyncBot\Plugin\WordOfTheDayTest\Fakes\HttpClient\MockResponseInterceptor;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

class GetFromDictionaryDotComTest extends TestCase
{
    public function testRetrieveThrowsOnInvalidHtml(): void
    {
        $httpClient = new Client(
            (new HttpClientBuilder())->intercept(
                new MockResponseInterceptor(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/DictionaryDotCom/valid.html')),
            )->build(),
        );

        $wordOfTheDay = wait((new GetFromDictionaryDotCom($httpClient))->retrieve());

        $this->assertInstanceOf(WordOfTheDay::class, $wordOfTheDay);
    }
}
