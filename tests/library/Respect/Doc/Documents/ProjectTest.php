<?php

namespace Respect\Doc\Documents;

use Respect\Test\StreamWrapper;

/**
 * Getting Information About A Project
 *
 */
class ProjectTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        StreamWrapper::setStreamOverrides(array());
    }
    
    public function tearDown()
    {
        StreamWrapper::releaseOverrides();
    }
    
    public function test()
    {
    
    $project = new Project('/example/project');
    
    }
}
