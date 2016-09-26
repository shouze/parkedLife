<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\App\Exception;

class NotFoundResource extends \Exception
{
    public static function ofType($resourceName, $resourceId)
    {
        return new static(sprintf('Unknow "%s" resource with id %s', $resourceName, $resourceId));
    }
}
