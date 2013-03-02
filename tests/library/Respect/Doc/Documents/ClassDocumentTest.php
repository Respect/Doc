<?php

namespace Respect\Doc\Documents;

/**
 * Getting Information About Tested Classes
 *
 * ClassDocument allows you to explore a class and find out relevant document
 * information about it.
 *
 * @covers Respect\Doc\Documents\ClassDocument
 */
class ClassDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Constructing Using Class names
     *
     * @covers Respect\Doc\Documents\ClassDocument::__construct
     */
    public function testConstructorWithStrings()
    {
        $ClassDocument = new ClassDocument("My\\Sample");
                
        $this->assertInstanceOf(
            "My\\Sample",
            $ClassDocument->tested,
            'The variable $ClassDocument->tested gets the test instance'
        );
        
        $this->assertEquals(
            "My\\Sample",
            (string) $ClassDocument,
            'The variable $ClassDocument as string gets the test case class name'
        );
    }
    /**
     * Constructing Using Instances
     *
     * @covers Respect\Doc\Documents\ClassDocument::__construct
     */
    public function testConstructorWithInstances()
    {
        $ClassDocument = new ClassDocument(new \My\Sample);
                
        $this->assertInstanceOf(
            "My\\Sample",
            $ClassDocument->tested,
            'The variable $ClassDocument->tested gets the test instance'
        );
        
        $this->assertEquals(
            "My\\Sample",
            (string) $ClassDocument,
            'The variable $ClassDocument as string gets the test case class name'
        );
    }
    
    public function testGettingMethods()
    {
        $classDocument = new ClassDocument(new \My\Sample);
        $methods = $classDocument->methods;
        $methodsDoc = $methods->doc();
        $this->assertInstanceOf("Respect\\Doc\\Documents\\Methods", $methods);
    }
    
}

namespace My;
class Sample 
{
    public function foo() {}
    public function bar() {}
}
