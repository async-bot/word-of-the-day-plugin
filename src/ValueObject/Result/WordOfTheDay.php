<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\ValueObject\Result;

class WordOfTheDay
{
    private string $word;

    private string $url;

    private string $definition;

    public function __construct(string $word, string $url, string $definition)
    {
        $this->word       = $word;
        $this->url        = $url;
        $this->definition = $definition;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }
}
