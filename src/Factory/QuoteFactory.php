<?php

namespace App\Factory;

use App\Entity\Quote;
use App\Event\QuoteCreatedEvent;
use App\Repository\QuoteRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Quote>
 *
 * @method static Quote|Proxy                     createOne(array $attributes = [])
 * @method static Quote[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Quote[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Quote|Proxy                     find(object|array|mixed $criteria)
 * @method static Quote|Proxy                     findOrCreate(array $attributes)
 * @method static Quote|Proxy                     first(string $sortedField = 'id')
 * @method static Quote|Proxy                     last(string $sortedField = 'id')
 * @method static Quote|Proxy                     random(array $attributes = [])
 * @method static Quote|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Quote[]|Proxy[]                 all()
 * @method static Quote[]|Proxy[]                 findBy(array $attributes)
 * @method static Quote[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Quote[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static QuoteRepository|RepositoryProxy repository()
 * @method        Quote|Proxy                     create(array|callable $attributes = [])
 */
final class QuoteFactory extends ModelFactory
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'content' => self::faker()->unique()->sentence(),
            'meta' => self::faker()->unique()->name(),
            'author' => UserFactory::new(),
        ];
    }

    protected static function getClass(): string
    {
        return Quote::class;
    }

    protected function initialize(): self
    {
        return $this
            ->afterPersist(function (Quote $quote) {
                $event = new QuoteCreatedEvent($quote);
                $this->eventDispatcher->dispatch($event);
            });
    }
}
