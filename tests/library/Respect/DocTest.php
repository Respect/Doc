<?php
namespace Respect;

class DocTest extends \PHPUnit_Framework_TestCase
{
	public function test_as_example_for___toString_method()
	{
		$class     = 'Respect\Doc';
		$doc       = new Doc($class);
		$markdown  = (string) $doc;
		$doc       = file_put_contents('../README.md', $markdown); //Happy Panda
		$this->assertStringEqualsFile('../README.md', $markdown);
	}
    public function test_as_example_for___construct_method_with_namespace()
    {
        $doc = new Doc('Respect'); //Full Namespace
        $this->assertStringStartsWith('# Respect', (string) $doc);
    }
    public function test_as_example_for___construct_method_with_class()
    {
        $doc = new Doc('Respect\Doc'); //Specific class Name
        $this->assertStringStartsWith('# Respect\Doc', (string) $doc);
    }
}