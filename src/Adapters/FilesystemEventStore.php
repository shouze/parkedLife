<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Adapters;

use SplFileObject;
use Shouze\ParkedLife\EventSourcing\EventStore;
use Shouze\ParkedLife\EventSourcing\EventSerializer;
use Shouze\ParkedLife\EventSourcing\Stream;
use Shouze\ParkedLife\EventSourcing\StreamName;
use Shouze\ParkedLife\EventSourcing\EventBus;
use Shouze\ParkedLife\Ports\FileHelper;

class FilesystemEventStore implements EventStore
{
    private $baseDir;

    private $eventSerializer;

    private $fileHelper;

    private $eventBus;

    public function __construct(string $baseDir, EventSerializer $eventSerializer, FileHelper $fileHelper, EventBus $eventBus)
    {
        $this->baseDir = $baseDir;
        $this->eventSerializer = $eventSerializer;
        $this->fileHelper = $fileHelper;
        $this->eventBus = $eventBus;
    }

    public function commit(Stream $eventStream)
    {
        $filename = $this->filename($eventStream->getStreamName());
        $content = '';
        foreach ($eventStream->getChanges() as $change) {
            $content .= $this->eventSerializer->serialize($change).PHP_EOL;
        }

        $this->fileHelper->appendSecurely($filename, $content);

        foreach ($eventStream->getChanges() as $change) {
            $this->eventBus->publish($change);
        }
    }

    public function fetch(StreamName $streamName): Stream
    {
        $filename = $this->filename($streamName);
        $lines = $this->fileHelper->readIterator($filename);
        $events = new \ArrayIterator();
        foreach ($lines as $serializedEvent) {
            $events->append($this->eventSerializer->deserialize($serializedEvent));
        }
        $lines = null; // immediately removes the descriptor.

        return new Stream($streamName, $events);
    }

    private function filename(StreamName $streamName): string
    {
        $hash = sha1($streamName->__toString());

        return
            $this->baseDir.'/streams/'.
            substr($hash, 0, 2).'/'.
            substr($hash, 2, 2).'/'.
            $hash
        ;
    }
}
