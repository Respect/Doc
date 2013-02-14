<?php
namespace Respect\Doc;

class DocTest extends \PHPUnit_Framework_TestCase
{
	public function test_as_example_for___toString_method()
	{
		$class     = 'Respect\Doc';
		$doc       = new Doc($class);
		$markdown  = (string) $doc;
		$doc       = file_put_contents('/tmp/README.md', $markdown); //Happy Panda
		$this->assertStringEqualsFile('/tmp/README.md', $markdown);
	}
    public function test_as_example_for___construct_method_with_namespace()
    {
        $doc    = new Doc('Respect'); //Full Namespace
        $title  = 'Respect\Doc\Doc' . PHP_EOL 
                . '===========';
        $this->assertStringStartsWith($title, (string) $doc);
    }
    public function test_as_example_for___construct_method_with_class()
    {
        $doc    = new Doc('Respect\Doc'); //Specific |class Name
        $title  = 'Respect\Doc\Doc' . PHP_EOL 
                . '===========';
        $this->assertStringStartsWith($title, (string) $doc);
    }
    public function test_getMarkDownforNamespace()
    {
        $doc    = new Doc('Respect');
        $content =  (string)$doc;
        $this->assertGreaterThanOrEqual( 100, strpos($content,'Respect\\Doc\MarkDown'));
        $this->assertGreaterThanOrEqual( 50, strpos($content,'Respect\Doc\DocItem'));
        $this->assertEquals( 0, strpos($content,'Respect\Doc\Doc'));
    }
    
    public function testgetMarkDownFromNameSpace()
    {    
        $reference = __DIR__."/../../../output/namespace_output.txt";
        $doc    = new Doc('Respect\Doc', Doc::DOCNS);
        $content =  file_get_contents($reference);
        $this->AssertEquals($content, (string)$doc);
    }
}
