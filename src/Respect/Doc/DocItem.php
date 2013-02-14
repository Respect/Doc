<?php

namespace Respect\Doc;

use SplObjectStorage,
    ReflectionClass,
    ReflectionMethod,
    ReflectionProperty;

/**
 * An item to be documented.
 */
class DocItem
{
    const FOR_CONCRETE_CLASS = false;
    const FOR_TEST_CLASS = true;
    private $className;

    /**
     * __construct Construct a doc Item
     *
     * @access public
     * @return void
     */
    public function __construct($whatDoYouWantToDocument)
    {
       $this->className = $whatDoYouWantToDocument;
    }

    public function getReflection($for=self::FOR_CONCRETE_CLASS)
    {
        $className     = $this->className;
        $testClassName = $this->className.'Test';
        if ($for === self::FOR_TEST_CLASS && class_exists($testClassName)) {
            return new ReflectionClass($testClassName);
        }

        return new ReflectionClass($className);
    }

    /**
     * @TODO Accept at least the same options supported on phpunit.xml for valid test case names.
     */
    public function getSections()
    {
        $sections         = new SplObjectStorage;
        $targetReflection = $this->getReflection(self::FOR_CONCRETE_CLASS);
        $targetClassName  = $targetReflection->getName();
        $testReflection   = $this->getReflection(self::FOR_TEST_CLASS);
        $testCaseMethods  = array();
        if ($testReflection instanceof ReflectionClass) {
            $testCaseMethods = $testReflection->getMethods();
        }

        $methods          = $targetReflection->getMethods(ReflectionMethod::IS_PUBLIC ^ ReflectionMethod::IS_STATIC);
        $properties       = $targetReflection->getProperties(ReflectionProperty::IS_PUBLIC ^ ReflectionProperty::IS_STATIC);
        $staticMethods    = $targetReflection->getMethods(ReflectionMethod::IS_PUBLIC & ReflectionMethod::IS_STATIC);
        $staticProperties = $targetReflection->getProperties(ReflectionProperty::IS_PUBLIC & ReflectionProperty::IS_STATIC);

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
        $sections         = array();
        $targetReflection = $this->getReflection();
        $class            = $targetReflection->getName();
        $sections[$class] = $targetReflection->getDocComment();
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

