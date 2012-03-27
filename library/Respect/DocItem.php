<?php
namespace Respect;

use \SplObjectStorage;
use \ReflectionClass;
use \ReflectionMethod;
use \ReflectionProperty;


/**
 * DocItem Reflection Class to speak where is the socks to rock it.  
 * 
 * @author Ivo Nascimento <ivo.nascimento@php.net> 
 */
class DocItem
{
    private $item;
    private $refItem;

    /**
     * __construct Construct a doc Item 
     * 
     * @access public
     * @return void
     */
    public function __construct($item)
    {
       $this->docItem =  $item;
       $this->refItem = new ReflectionClass($item);
    }
    public function getName()
    {
        return $this->refItem->getName();
    }
    public function getDocComment()
    {
    }
}

