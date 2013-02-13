<?php
namespace  Respect\Doc;
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    
    public function test__construct()
    {
        $a = new Exception("Mensagem Doc");
        $this->AssertEquals("Mensagem Doc", $a->getMessage());
    }
}