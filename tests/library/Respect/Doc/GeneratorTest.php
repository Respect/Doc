<?php
namespace Respect\Doc;
use Respect\Doc\Reflection;

class GeneratorExampleTest extends \PHPUnit_Framework_TestCase
{
	public function test_doc_for_reflection_class()
	{
		$class    = 'Respect\Doc\GeneratorMock';
		$expected = <<<'MD'
# Respect\Doc\GeneratorMock

Generates the markdown for a given path.

## something

@var Foo

## static zHelloFunction($foo, $bar, $baz=null)

## __construct($classname)

## __toString()
MD;
		$generator = new Generator($class);
		$markdown  = (string) $generator;
		$this->assertEquals($expected, trim($markdown));
	}

	public function test_as_example_for___toString()
	{

	}
}

/**
 * Generates the markdown for a given path.
 */
class GeneratorMock
{
	/** @var Foo */
	public $something;

	public function __construct($classname)
	{
		$this->ns = $classname;
	}

	public function __toString()
	{
		$sections = array();
		$md       = '';
		return $this->getMarkdown($this->getSections());
		
	}

	public static function zHelloFunction($foo, $bar, $baz=null) {

	}

}