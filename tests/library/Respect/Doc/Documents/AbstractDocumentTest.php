<?php

namespace Respect\Doc\Documents;
use CastableToString;
use Respect\Doc\Explorations as e;

/**
 * Creating New Text Documents
 *
 * To create new text documents, you must extend the AbstractDocument class
 * and place the child in the Respect\Doc\Documents\ namespace. 
 *
 * @covers Respect\Doc\Documents\AbstractDocument
 */
class AbstractedDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Constructor Default Behavior
     * 
     * @covers Respect\Doc\Documents\AbstractDocument
     * @covers Respect\Doc\Documents\AbstractDocument::__construct
     * @covers Respect\Doc\Documents\AbstractDocument::__toString
     * @covers Respect\Doc\Documents\AbstractDocument::doc
     * 
     * @dataProvider provideTested
     */
    public function testConstructor($expected, $tested)
    {
        $doc = new \My\SimpleTestedClass($tested);
                
        $this->assertEquals(
            $tested,
            $doc->tested,
            'By default, the constructor sets $tested->tested'
        );
        
        $this->assertEquals(
            $expected,
            (string) $doc,
            'By default, casting to string leads to printing/imploding $tested->doc()'
        );
        
        $this->assertEquals(
            $doc->tested,
            $doc->doc(),
            'By default, $tested->doc() justs prints $tested->tested'
        );
    }
    /**
     * Constructor Variations
     *
     * 0. Subject as string
     * 1. Subject as array
     * 2. Subject as castable object
     */
    public function provideTested()
    {
        return array(
            0 =>  array("My\\OneSimpleTest", "My\\OneSimpleTest"),
            1 =>  array("My\\OneSimpleTest", array('My\\OneSimpleTest')),
            2 =>  array("My\\OneSimpleTest", new \My\OneSimpleTest)
        );
    }
    /**
     * Testing if Explorations are Available
     *
     * @covers Respect\Doc\Documents\AbstractDocument::explorable
     * @covers Respect\Doc\Documents\AbstractDocument::__isset
     */
    public function testMethodExplorable()
    {
        $doc = new \My\TestedClassWithExploration;
        
        $this->assertTrue(
            $doc->explorable('method'),
            '$doc points to OneWithAnExplorableMethod class which implements MethodExploration, thus is explorable to "method"'
        );
        
        $this->assertFalse(
            $doc->explorable('madagascar'),
            'Missing explorations should return false'
        );
        
        $this->assertFalse(
            $doc->explorable('instantiation'),
            '$doc points to OneWithAnExplorableMethod class which does not implements InstantiationExploration, thus is not explorable to "instantiation"'
        );
        
        $this->assertEquals(
            $doc->explorable('method'),
            isset($doc->method),
            'Magic $doc->__isset() points to $doc->explorable() and should return the same results.'
        );
    }
    /**
     * Getting Explorations
     *
     * @covers Respect\Doc\Documents\AbstractDocument::explore
     * @covers Respect\Doc\Documents\AbstractDocument::__get
     */
    public function testMethodExplore()
    {
        $doc = new \My\TestedClassWithExploration;
        
        $this->assertInstanceOf(
            "Respect\\Doc\\Documents\\Method",
            $doc->explore('method'),
            '$doc points to OneWithAnExplorableMethod class which implements MethodExploration, thus is explorable to "method"'
        );
        
        $this->assertEquals(
            $doc->explore('method'),
            $doc->method,
            'Magic $doc->__get() points to $doc->explore() and should return the same results.'
        );
        
        $this->assertEmpty(
            $doc->explore('madagascar'),
            'Missing explorations should return an empty string'
        );
        
        $this->assertEmpty(
            $doc->instantiation,
            'Missing explorations should return an empty string'
        );
        
    }
}

namespace My;

use Respect\Doc\Documents\AbstractDocument;
use Respect\Doc\Explorations as e;

/**
 * This class just extends AbstractDocument and inherits it's behavior.
 */
class SimpleTestedClass extends AbstractDocument 
{
}

/**
 * This class implements Respect\Doc\Explorations\MethodExplorartion, which
 * makes it return true for $this->explorable("method") and a new instance
 * of Respect\Doc\Tests\TestedMethod for $this->explore("method").
 */
class TestedClassWithExploration extends AbstractDocument implements 
    e\MethodExploration
{
    public function __construct()
    {
    }
}

class OneSimpleTest
{
}

class OneSimple
{
}

class AnotherSimpleTest
{
}

class AnotherSimple
{
    public function __toString()
    {
        return __CLASS__;
    }
}
