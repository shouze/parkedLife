<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\IdentifiesAggregate;

class UserId implements IdentifiesAggregate
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public static function fromString(string $string)
    {
        return new UserId($string);
    }

    public function __toString(): string
    {
        return $this->userId;
    }

    public function equals(IdentifiesAggregate $other): bool
    {
        return
            $other instanceof UserId
            && $this->userId == $other->userId
        ;
    }

}
