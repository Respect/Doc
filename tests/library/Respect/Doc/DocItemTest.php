<?php
namespace Respect\Doc;                               
                                                 
class DocItemTest extends \phpunit_framework_testcase
{
    private $docItem;
    public function setUp()
    {
        $this->docItem = new DocItem( 'Respect\Doc\DocItem');
    }
    public function tearDown()
    {
        $this->docItem = null;
    }
    public function test_getName()
    {
        $this->AssertEquals('Respect\Doc\DocItem', $this->docItem->getName());
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
        $this->AssertInstanceOf('SplObjectStorage',$this->docItem->getSections());
    }
    public function test_getClassContents()
    {
        $doc = new Doc('\Respect\Doc\Doc');
        $content = \file_get_contents (__DIR__."/../../../output/RespectDoc_output.txt");
        $this->AssertEquals($content, (string)$doc);
    }
}