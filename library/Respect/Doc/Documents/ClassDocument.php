<?php

namespace Respect\Doc\Documents;

use Respect\Doc\Explorations as e;

class ClassDocument extends AbstractDocument implements 
    e\MethodsExploration
{   
    public function __construct($tested)
    {
        parent::__construct(new $tested);
    }
    public function doc()
    {
        return $this->tested;
    }
}
