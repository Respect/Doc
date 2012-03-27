<?php
namespace Respect;                               
                                                 
class DocItemTest extends \PHPUnit_Framework_TestCase
{
    private $docItem;
    public function setUp()
    {
        $this->docItem = New DocItem( 'Respect\Doc');
    }
    public function tearDown()
    {
        $this->docItem = null;
    }
    public function test_getName()
    {
        $this->AssertEquals('Respect\Doc', $this->docItem->getName());
    }
}
