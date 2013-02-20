<?php

namespace Respect\Doc\Documents;

class MethodTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $testedClass = new ClassDocument("My\\MethodSample");
        
        $method = new Method($testedClass, "sample");
        $this->assertContains(
            'sample',
            $method->doc(),
            '$method->doc() should return the name of the method'
        );
    }
}

namespace My;
class MethodSample 
{
    public function sample()
    {
    }
}
