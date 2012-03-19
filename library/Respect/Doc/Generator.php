<?php
namespace Respect\Doc;

use \ReflectionClass;
use \ReflectionMethod;
use \ReflectionProperty;

/**
 * Generates the markdown for a given path.
 */
class Generator
{
	protected $ns;
	protected $reflections=array();
	protected $sections=array();

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

	protected function getSections()
	{
		$path = $this->ns;

		if (!class_exists($path))
			return array();

		$sections = array();
		$classes  = array($path);
		foreach ($classes as $class) {
			$reflection       = new ReflectionClass($class);
			$class            = $reflection->getName();
			$sections[$class] = $reflection->getDocComment();

			foreach ($this->findSections($reflection) as $sub) {
				if ($sub->isStatic())
					$subName = 'static ';
				else
					$subName = '';

				$subName .= $sub->getName();
				$name     = $class.'::'.$subName;

				if ($sub instanceof ReflectionMethod)
					if ($sub->getNumberOfRequiredParameters() <= 0)
						$name .= '()';
					else {
						$params = $sub->getParameters();
						$tmp    = array();
						foreach ($params as $param) {
							if ($param->isArray())
								$tmp[] = 'array ';
							if ($param->isOptional())
								$tmp[] = '$'.$param->getName().'=null';
							elseif ($param->isDefaultValueAvailable())
								$tmp[] = '$'.$param->getName().'='.$param->getDefaultValue();
							else
								$tmp[] = '$'.$param->getName();
						}
						$name .= '('.implode(', ', $tmp).')';
					}
					

				$sections[$name] = $sub->getDocComment();
			}
				
		}
		return $sections;
	}

	protected function findSections(ReflectionClass $reflection) {

		$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC ^ ReflectionMethod::IS_STATIC);
		$properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC ^ ReflectionProperty::IS_STATIC);
		$staticMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC & ReflectionMethod::IS_STATIC);
		$staticProperties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC & ReflectionProperty::IS_STATIC);

		$nameSort = function($a, $b) {
			return strnatcasecmp($a->getName(), $b->getName());
		};

		usort($methods, $nameSort);
		usort($properties, $nameSort);
		usort($staticMethods, $nameSort);
		usort($staticProperties, $nameSort);
		return array_merge($staticProperties, $properties, $staticMethods, $methods);
	}

	protected function getMarkdown(array $sections)
	{
		$string = array();
		foreach ($sections as $name=>$content) {
			
			if (preg_match_all('/[\:]{1,2}(.*)/', $name, $matches))
				$name = $matches[1][0];
			else 
				$matches = 1;

			$content  = trim(preg_replace('#^[ /*]*(.*?)[ /*]*$#m', '$1', $content));
			$string[] = trim(str_repeat('#', count($matches)).' '.$name."\n\n".$content);
		}
		return implode("\n\n", $string);
	}
}