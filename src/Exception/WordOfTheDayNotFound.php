<?php declare(strict_types=1);

namespace AsyncBot\Plugin\WordOfTheDay\Exception;

class WordOfTheDayNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Could not find the Word of the Day');
    }
}
