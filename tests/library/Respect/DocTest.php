<?php
namespace Respect;

class DocTest extends \PHPUnit_Framework_TestCase
{
	public function test_as_example_for___toString_method()
	{
		$class     = 'Respect\Doc';
		$generator = new Doc($class);
		$markdown  = (string) $generator;
		$doc       = file_put_contents('../README.md', $markdown); //Happy Panda
		print $markdown;
		$this->assertStringEqualsFile('../README.md', $markdown);
	}
}