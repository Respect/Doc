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
