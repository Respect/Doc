<?php
namespace Respect\Doc;                               
                                                 
class NameSpaceAnalizerTest extends \phpunit_framework_testcase
{
    private $namespace;
    public function setUp()
    {
        $this->namespace = new NameSpaceAnalizer();
    }
    public function tearDown()
    {
        $this->namespace = null;
    }
}
