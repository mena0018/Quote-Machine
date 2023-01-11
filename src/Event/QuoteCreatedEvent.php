<?php

namespace App\Event;

use App\Entity\Quote;
use Symfony\Contracts\EventDispatcher\Event;

class QuoteCreatedEvent extends Event
{
    public function __construct(protected Quote $quote)
    {
    }

    public function getQuote(): Quote
    {
        return $this->quote;
    }
}
