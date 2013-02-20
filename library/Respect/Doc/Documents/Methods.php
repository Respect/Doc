<?php

namespace Respect\Doc\Documents;

use Respect\Doc\Explorations as e;

class Methods extends AbstractDocument implements 
    e\ExplorationList,
    e\MethodExploration
{   
    public static $considers = array();
    
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
        return $this->getIterator();
    }
    
    public function getIterator()
    {
        $testedClass = $this->tested;
        $allMethods = get_class_methods($testedClass->tested);
        
        if (!static::$considers) {
            return $allMethods;
        }
        
        return array_values(array_filter(array_map(
            function ($method) use ($testedClass) {
                if (static::considers($method)) {
                    return $testedClass->methods[$method];
                }
            }, 
            $allMethods
        )));
    }
    
    public function offsetGet($name)
    {
        return new Method($this->tested, $name);
    }
}
