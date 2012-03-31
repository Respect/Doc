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
        $allFilesInNameSpace   = $this->ns->get($class);
        $this->AssertInstanceOf('DirectoryIterator', $allFilesInNameSpace);
        $files = 0;
        while($allFilesInNameSpace->valid()) {
            $files += (!$allFilesInNameSpace->isDir())?1:0;
            $allFilesInNameSpace->next();
        }
        $this->AssertEquals(4, $files);
    }
}
