<?php

namespace Respect\Doc\Documents;

/**
 * Getting Information About Tested Classes
 *
 * ClassDocument allows you to explore a test case and find out information
 * about how it works.
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
}

namespace My;
class Sample 
{
}
