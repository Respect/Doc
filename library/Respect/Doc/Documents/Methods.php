<?php

namespace Respect\Doc\Documents;

use Respect\Doc\Explorations as e;

class Methods extends AbstractDocument implements 
    e\ExplorationList,
    e\MethodExploration
{   
    public static $considers = array('/.*/');
    
    public function __construct(ClassDocument $tested)
    {
        return parent::__construct($tested);
    }
    
    public static function considers($name)
    {
        foreach (static::$considers as $pattern) {
            if (preg_match($pattern, $name)) {
                return $name;
            }
        }
    }
    
    public function doc()
    {
        return iterator_to_array($this);
    }
    
    public function getIterator()
    {
        $testedClass = $this->tested;
        $allMethods = get_class_methods($testedClass->tested);
        
        $methodsInstances = array();
        
        foreach ($allMethods as $method) {
            if (empty(static::$considers) || static::considers($method)) {
                $methodsInstances[$method] = new Method($this->tested, $method);
            }
        }
        
        return new \ArrayObject($methodsInstances);
    }
    
    public function offsetGet($name)
    {
        return new Method($this->tested, $name);
    }
}
