<?php

namespace Respect\Doc\Documents;

use Respect\Doc\Explorations as e;

class Method extends AbstractDocument implements e\Exploration
{   
    public $name;
    
    public function __construct($tested, $name = null)
    {
        parent::__construct($tested);
        $this->name = $name;
    }
    public function doc()
    {
        return $this->name;
    }
}
