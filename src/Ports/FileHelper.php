<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Ports;

use SplFileObject;

class FileHelper
{
    public function readIterator(string $filename): \Iterator
    {
        try {
            $fileObject = new SplFileObject($filename);
            $fileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);
        } catch (\Exception $e) {
            throw new \LogicException(sprintf('Unable to build a read iterator for file "%s"', $filename), 0, $e);
        }

        return $fileObject;
    }

    public function appendSecurely(string $filename, string $content)
    {
        $dir = dirname($filename);

        if (false === is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fd = fopen($filename, 'a');
        if (false == flock($fd, LOCK_EX)) {
            throw new \LogicException(sprintf('Cannot lock file "%s".'), $filename);
        }

        $result = fwrite($fd, $content);
        flock($fd, LOCK_UN);
        fclose($fd);

        if ($result === false) {
            throw new \RuntimeException(sprintf('Write errror on file "%s".', $filename));
        }
    }
}
