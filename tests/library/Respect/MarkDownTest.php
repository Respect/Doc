<?php
namespace Respect;                               
                                                 
class MarkDownTest extends \phpunit_framework_testcase
{
    public function testget()
    {

        $doc = new DocItem('\Respect\Doc');
        $markdown = new MarkDown();
        $content = \file_get_contents (__DIR__."/../../output/RespectDoc_output.txt");
        $sections = (array)$doc->getClassContent();
        $this->AssertEquals($content, $markdown->get($sections));
 
    }
}
