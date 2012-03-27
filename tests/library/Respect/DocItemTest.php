<?php
namespace Respect;                               
                                                 
class DocItemTest extends \PHPUnit_Framework_TestCase
{
    private $docItem;
    public function setUp()
    {
        $this->docItem = New DocItem( 'Respect\DocItem');
    }
    public function tearDown()
    {
        $this->docItem = null;
    }
    public function test_getName()
    {
        $this->AssertEquals('Respect\DocItem', $this->docItem->getName());
    }
    public function test_getDocComment()
    {
        $returnValue = "/**
 * DocItem Reflection Class to speak where is the socks to rock it.  
 * 
 * @author Ivo Nascimento <ivo.nascimento@php.net> 
 */";
        $this->AssertEquals($returnValue, $this->docItem->getDocComment());
}

    public function getMethodsDataprovider()
{    
        return array(
                array(0,'__construct'),
                array(1,'getName'),
                array(2,'getDocComment'),
                array(3,'__call')
        );
    }
    /**
     * @dataProvider getMethodsDataprovider  
     */
    public function test_getMethods($idx, $name)
    {
        $methods = $this->docItem->getMethods();
        $this->AssertEquals($methods[$idx]->name, $name );
    }
    public function test_getSections()
    {
        $docItem = New DocItem( 'Respect\DocItem');
             var_dump($docItem->getSections());
    }
    
}
