<?php

namespace Respect\Doc;

use ReflectionClass;

class DocItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Class to be used as an item to be documented on these tests.
     * If you change this, you are "probably" going to change some assertions also.
     */
    const DOC_ITEM_CLASS = 'Respect\Doc\DocItem';

    /**
     * @covers Respect\Doc\DocItem::__construct
     */
    public function test_new_instance_with_class_name()
    {
        $this->assertInstanceOf(
            $expected = 'Respect\Doc\DocItem',
            $result   = new DocItem(self::DOC_ITEM_CLASS)
        );
    }

    /**
     * @covers Respect\Doc\DocItem::__construct
     * @expectedException           PHPUnit_Framework_Error
     * @expectedExceptionMessage    Missing argument 1 for
     */
    public function test_new_instance_without_argument_fails()
    {
        $this->assertInstanceOf(
            $expected = 'Respect\Doc\DocItem',
            $result   = new DocItem
        );
    }

    /**
     * @covers Respect\Doc\DocItem::getName
     */
    public function test_getName_returns_the_name_of_the_class()
    {
        $item = new DocItem(self::DOC_ITEM_CLASS);
        $this->AssertEquals('Respect\Doc\DocItem', $item->getName());
    }

    /**
     * @covers Respect\Doc\DocItem::getDocComment
     */
    public function test_get_phpdoc_from_class()
    {
        $item     = new DocItem(self::DOC_ITEM_CLASS);
        $expected = <<<PHPDOC
/**
 * DocItem Reflection Class to speak where is the socks to rock it.
 *
 * @author Ivo Nascimento <ivo.nascimento@php.net>
 */
PHPDOC;
        $this->assertEquals(
            $expected,
            $result = $item->getDocComment()
        );
}

    /**
     * @covers Respect\Doc\DocItem::getMethods
     */
    public function test_getMethods_retrieves_all_method_names()
    {
        $item       = new DocItem(self::DOC_ITEM_CLASS);
        $reflection = new ReflectionClass(self::DOC_ITEM_CLASS);
        $this->assertEquals(
            count($expected = $reflection->getMethods()),
            count($result   = $item->getMethods()),
            'Expected a different quantity of methods as result.'
        );
        $this->assertContainsOnlyInstancesOf(
            'ReflectionMethod',
            $result,
            'Resulting methods is not an array of ReflectionMethod instances.'
        );
        // Converts an array of ReflectionMethods into an array of strings with method names only.
        $conversor       = function($reflectionMethod) { return $reflectionMethod->getName(); };
        $expectedMethods = array_map($conversor, $expected);
        // For every ReflectionMethod instance returned
        foreach ($result as $resultingMethod)
            $this->assertContains(
                $expectedMethodName = $resultingMethod->getName(),
                $expectedMethods,
                sprintf('Expected method "%s" to exist into class "%s"', $expectedMethodName, $reflection->getName())
            );
    }

    /**
     * @TODO Improve name and code coverage of this test.
     * @covers Respect\Doc\DocItem::getSections
     */
    public function test_getSections()
    {
        $item = new DocItem(self::DOC_ITEM_CLASS);
        $this->AssertInstanceOf(
            'SplObjectStorage',
            $item->getSections()
        );
    }

    /**
     * @TODO Improve test name reducing the code covered by this test.
     * @covers Respect\Doc\DocItem
     * @covers Respect\Doc\Doc
     */
    public function test_getClassContents()
    {
        $doc      = new Doc('\Respect\Doc\Doc');
        $expected = file_get_contents("RespectDoc_output.txt", $useIncludePath=true);
        $this->assertEquals(
            $expected,
            $result = (string)$doc
        );
    }
}
