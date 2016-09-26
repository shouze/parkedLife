<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Adapters;

use Symfony\Component\Serializer\Serializer;
use Shouze\ParkedLife\Domain\ReadModel\Projector;
use Shouze\ParkedLife\Domain\ReadModel\Projection;

class JsonProjector implements Projector
{
    private $serializer;

    private $rootDir;

    public function __construct(string $rootDir, Serializer $serializer)
    {
        $this->rootDir = $rootDir;
        $this->serializer = $serializer;
    }

    public function saveProjection(Projection $projection)
    {
        $path = $this->buildPath(
            get_class($projection),
            $projection->getAggregateId()
        );
        $dir = dirname($path);

        if (false === is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(
            $path,
            $this->serializer->serialize($projection, 'json')
        );
    }

    public function readProjection(string $className, string $aggregateId)
    {
        $path = $this->buildPath($className, $aggregateId);

        if (false === file_exists($path)) {
            return null;
        }

        return $this->serializer->deserialize(file_get_contents($path), $className, 'json');
    }

    private function buildPath($className, $aggregateId)
    {
        $hash = sha1($className.$aggregateId);
        return
            $this->rootDir.'/'.
            'projections/'.
            substr($hash, 0, 2).'/'.
            substr($hash, 2, 2).'/'.
            $hash
        ;
    }
}
