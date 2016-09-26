<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Ports;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

class CommandClassAsMethodInflector implements MethodNameInflector
{
    /**
     * {@inheritdoc}
     */
    public function inflect($command, $commandHandler)
    {
        $parts = explode("\\", get_class($command));

        return str_replace("Command", "", lcfirst(end($parts)));
    }
}
