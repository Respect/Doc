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
        $this->AssertEquals('---', $this->docItem->getDocComment());
    }
}
