<?php
namespace Respect\Doc;

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
    private function getName()
    {
        return $this->refItem->getName();
    }
    private function getDocComment()
    {
        return $this->refItem->getDocComment();
    }
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->refItem, $method),$parameters );
    }
    private function getMethods($scope=null)
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
    public function getClassContent()
    {
        $sections = array();
        $class            = $this->getName();
        $sections[$class] = $this->getDocComment();
        $reflectors = $this->getSections();
        foreach ($reflectors as $sub) {
            $tests = $reflectors[$sub];
            if ($sub->isStatic())
                $subName = 'static ';
            else
                $subName = '';

            $subName .= $sub->getName();
            $name     = $class.'::'.$subName;

            if ($sub instanceof ReflectionMethod)
                if ($sub->getNumberOfRequiredParameters() <= 0)
                    $name .= '()';
                else {
                    $params = $sub->getParameters();
                    $tmp    = array();
                    foreach ($params as $param) {
                        if ($param->isArray())
                            $tmp[] = 'array ';
                        if ($param->isOptional())
                            $tmp[] = '$'.$param->getName().'=null';
                        elseif ($param->isDefaultValueAvailable())
                            $tmp[] = '$'.$param->getName().'='.$param->getDefaultValue();
                        else
                            $tmp[] = '$'.$param->getName();
                    }
                    $name .= '('.implode(', ', $tmp).')';
                }

                $sections[$name] = $sub->getDocComment();
                // Fetch method content for examples
                foreach ($tests as $n => $test) {
                    $testCaseContents = file($test->getFilename());
                    $testSectionName  = "Example ".($n+1).":";
                    $testCaseLines    = array_slice($testCaseContents, 1+$test->getStartLine(), -2+$test->getEndLine()-$test->getStartLine());
                    $testCaseLines    = array_map(
                        function($line) {
                            if ($line{0} == "\t")
                                return substr($line, 1);
                            if ($line{0} == ' ')
                                return substr($line, 4);
                            else
                                return '    ' . $line;
                        },
                        $testCaseLines
                    );
                    $sections[$name] .= PHP_EOL.PHP_EOL.$testSectionName.PHP_EOL.PHP_EOL.implode($testCaseLines);
                }

            }
               return $sections;
        }
}

