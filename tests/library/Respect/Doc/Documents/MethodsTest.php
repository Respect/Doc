<?php

namespace Respect\Doc\Documents;

class MethodsTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->originalConsiders = Methods::$considers;
    }
    
    public function tearDown()
    {
        Methods::$considers = $this->originalConsiders;
    }
    
    /**
     * @dataProvider provideMethodNames
     */
    public function testConstructor($docResult, $stringResult, $pattern)
    {
        $testedClass = new ClassDocument("My\\MethodsSampleTest");
        
        $Methods = new Methods($testedClass);
        Methods::$considers = array($pattern);
        $this->assertContains(
            $docResult,
            $Methods->doc(),
            '$Methods->doc() should return an array with methods matching Methods::$considers'
        );
        $this->assertEquals(
            $stringResult,
            (string) $Methods,
            '$Methods->doc() should return an array with methods matching Methods::$considers'
        );
    }
    
    public function provideMethodNames()
    {
        return array(
            array("fooBar", "fooBar", "/fooBar/"),
            array("fooBar", "fooBar", "/^foo/"),
            array("fooBar", "fooBar,barBaz", "/bar/i") ,
            array("barBaz", "fooBar,barBaz", "/bar/i") 
        );
    }
}

namespace My;
class MethodsSampleTest
{
    public function __construct()
    {
    }
    public function fooBar()
    {
    }
    public function barBaz()
    {
    }
}
