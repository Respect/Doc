<?php
namespace Respect\Doc;                               
                                                 
class NameSpaceTest extends \phpunit_framework_testcase
{
    private $namespace;
    public function setUp()
    {
        $this->namespace = New NameSpace();
    }
    public function tearDown()
    {
        $this->namespace = null;
    }
}
