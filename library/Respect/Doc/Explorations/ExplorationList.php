<?php

namespace Respect\Doc\Explorations;

use IteratorAggregate;

interface ExplorationList extends IteratorAggregate
{
    public static function considers($name);
}
