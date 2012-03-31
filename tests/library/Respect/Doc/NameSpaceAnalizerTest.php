<?php
namespace Respect\Doc;                               
                                                 
class NameSpaceAnalizerTest extends \phpunit_framework_testcase
{
    private $ns;
    public function setUp()
    {
        $this->ns = new NameSpaceAnalizer();
    }
    public function tearDown()
    {
        $this->namespace = null;
    }
    public function testget()
    {
        $class                          =  new MarkDown();
        $arrayWithAllFilesInNameSpace   = $this->ns->get($class);
        $this->AssertCount(4, $arrayWithAllFilesInNameSpace);
    }
}
