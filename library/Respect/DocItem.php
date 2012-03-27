<?php
namespace Respect;

use \SplObjectStorage;
use \ReflectionClass;
use \ReflectionMethod;
use \ReflectionProperty;


/**
 * DocItem Reflection Class to speak where is the socks to rock it.  
 * 
 * @author Ivo Nascimento <ivo.nascimento@php.net> 
 */
class DocItem
{
    private $item;
    private $refItem;

    /**
     * __construct Construct a doc Item 
     * 
     * @access public
     * @return void
     */
    public function __construct($item)
    {
       $this->docItem =  $item;
       $this->refItem = new ReflectionClass($item);
    }
    public function getName()
    {
        return $this->refItem->getName();
    }
    public function getDocComment()
    {
        return $this->refItem->getDocComment();
    }
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->refItem, $method),$parameters );
    }
    public function getMethods($scope=null)
    {
        if (is_null($scope))
            return $this->refItem->getMethods();
        return $this->refItem->getMethods($scope);
    }
    public function getSections() 
    {
        $testCaseClass = $this->getName().'Test';

        if (class_exists($testCaseClass)) {
            $testCaseReflection = new ReflectionClass($testCaseClass);
            $testCaseMethods = $testCaseReflection->getMethods();
        } else {
            $testCaseMethods= array();
        }
        $sections = new SplObjectStorage;
        $methods = $this->getMethods(ReflectionMethod::IS_PUBLIC ^ ReflectionMethod::IS_STATIC);
        $properties = $this->getProperties(ReflectionProperty::IS_PUBLIC ^ ReflectionProperty::IS_STATIC);
        $staticMethods = $this->getMethods(ReflectionMethod::IS_PUBLIC & ReflectionMethod::IS_STATIC);
        $staticProperties = $this->getProperties(ReflectionProperty::IS_PUBLIC & ReflectionProperty::IS_STATIC);

        $nameSort = function($a, $b) {
            return strnatcasecmp($a->getName(), $b->getName());
        };

        usort($methods, $nameSort);
        usort($properties, $nameSort);
        usort($staticMethods, $nameSort);
        usort($staticProperties, $nameSort);
        foreach (array_merge($staticProperties, $properties, $staticMethods, $methods) as $method)
            $sections[$method] = array_values(array_filter($testCaseMethods, function($test) use($method) {
                                    return 0 === stripos($test->getName(), 'test_as_example_for_'.$method->getName().'_method');
                                 }));
        return $sections;
    }


}

