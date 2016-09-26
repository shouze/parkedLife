<?php

namespace Shouze\ParkedLife\Domain\ReadModel;

interface Projector
{
    public function saveProjection(Projection $projection);

    public function readProjection(string $className, string $aggregateId);
}
