<?php
declare(strict_types=1);


namespace AsyncBot\Plugin\WordOfTheDay\Exception;


class InvalidDOMStructure extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected html structure');
    }
}