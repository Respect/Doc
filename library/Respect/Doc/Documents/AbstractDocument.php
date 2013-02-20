<?php

namespace Respect\Doc\Documents;

use ArrayObject;

/**
 * An abstract tested part of a code base that can be explored for more 
 * documents.
 */
abstract class AbstractDocument extends ArrayObject
{
    /** @var mixed The target test data **/
    public $tested;
    
    /**
     * @param mixed $tested The target test subject
     */
    public function __construct($tested)
    {
        $this->tested = $tested;
    }
    
    /**
     * Checks a exploration by it's name. Looks for explorations
     * on Respect\Doc\Tests\Tested<ExplorationName>.php
     *
     * @param string $name Name of the exploration
     *
     * @return bool True if the exploration can be performed
     *
     * @see Respect\Doc\Documents\AbstractTested::explorable
     * @see Respect\Doc\Documents\AbstractTested::explore
     * @see Respect\Doc\Documents\AbstractTested::__get
     */
    public function __isset($name)
    {
        return $this->explorable($name);
    }
    
    /**
     * Gets a exploration by it's name. Looks for explorations
     * on Respect\Doc\Tests\Tested<ExplorationName>.php
     *
     * @param string $name Name of the exploration
     *
     * @return mixed Respect\Doc\Documents\AbstractTested or empty string
     *
     * @see Respect\Doc\Documents\AbstractTested::explorable
     * @see Respect\Doc\Documents\AbstractTested::explore
     * @see Respect\Doc\Documents\AbstractTested::__isset
     */
    public function __get($name)
    {
        return $this->explore($name);
    }
    
    /**
     * Checks a exploration by it's name. Looks for explorations
     * on Respect\Doc\Tests\Tested<ExplorationName>.php
     *
     * @param string $name Name of the exploration
     *
     * @return bool True if the exploration can be performed
     *
     * @see Respect\Doc\Documents\AbstractTested::__isset
     * @see Respect\Doc\Documents\AbstractTested::explore
     * @see Respect\Doc\Documents\AbstractTested::__get
     */
    public function explorable($name)
    {
        $name = ucfirst($name);
        $explorationName = "Respect\\Doc\\Explorations\\${name}Exploration"; 
        return $this instanceof $explorationName;
    }
     
    /**
     * Gets a exploration by it's name. Looks for explorations
     * on Respect\Doc\Tests\Tested<ExplorationName>.php
     *
     * @param string $name Name of the exploration
     *
     * @return mixed Respect\Doc\Documents\AbstractTested or empty string
     *
     * @see Respect\Doc\Documents\AbstractTested::explorable
     * @see Respect\Doc\Documents\AbstractTested::__get
     * @see Respect\Doc\Documents\AbstractTested::__isset
     */
    public function explore($name)
    {
        $name = ucfirst($name);
        $testedName = "Respect\\Doc\\Documents\\{$name}";
        if (class_exists($testedName) && $this->explorable($name)) {
            return new $testedName($this);
        } else {
            return '';
        }
    }
    
    /**
     * Returns the name of the tested subject. Tries to cast it to string or
     * implode depending on type
     */
    public function __toString()
    {
        $doc = $this->doc();
        if (is_object($doc) && !method_exists($doc, '__toString')) {
            return get_class($doc);
        } elseif (is_array($doc)) {
            return implode(',', $doc);
        } else {
            return (string) $doc;
        }
    }
    
    /**
     * By default, returns the test subject, but this method is intended to be
     * overriden.
     */
    public function doc()
    {
        return $this->tested;
    }
}
