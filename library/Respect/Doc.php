<?php
namespace Respect;


/**
 * Generates docs that rocks your socks off.
 * 
 * Why it rock your socks off:
 * 
 *   1. Tested code rocks! So it uses your PHPUnit tests as examples.
 *   2. Doc comments, like this, are really optional.
 *   3. This very documentation was generated by the project itself from the code itself.
 * 
 * @author  Alexandre Gaigalas <alexandre@gaigalas.net>
 * @author  Augusto Pascutti <augusto@phpsp.org.br>
 */
class Doc
{
    public $path;
    protected $reflections=array();
    protected $sections=array();

    /** Receives the namespace or class to be documented */
    public function __construct($classOrNamespace)
    {
        $this->path = $classOrNamespace;
    }

    /** Returns the documentation in markdown */
    public function __toString()
    {
        return $this->getMarkdown($this->getContents($this->path));
        
    }

    protected function getContents($path)
    {
        if (!class_exists($path))
            return $this->getNamespaceContents($path);
        else
            return $this->getClassContents($path);
    }

    protected function getNamespaceContents($path)
    {
        $sections = array();
        $declaredClasses = get_declared_classes();
        natsort($declaredClasses);
        foreach ($declaredClasses as $class)
            if (0 === stripos($class, $path) && false === strripos($class, 'Test'))
                $sections += $this->getClassContents($class);

        return $sections;
    }

    protected function getClassContents($path)
    {
        if (!class_exists($path))
            return array();

        $sections = array();
        $classes  = array($path);
        foreach ($classes as $class) {
            $docItem          = new DocItem($class);
            $class            = $docItem->getName();
            $sections = $docItem->getClassContent();
        }
        return $sections;
    }

    protected function getMarkdown(array $sections)
    {
        $string = array();
        foreach ($sections as $name=>$content) {
            
            if (preg_match_all('/[\:]{1,2}(.*)/', $name, $matches))
                $name = $matches[1][0];
            else 
                $matches = 1;

            $content  = trim(preg_replace('#^(\s*[*]|[/][*]{2}|[\][*])[/*]*(.*?)[ /*]*$#m', '$2', $content));
            $content  = preg_replace("#\\n\\n[ ]*@#", "\n\nMore Info:\n\n@", $content);
            $content  = preg_replace_callback('#^[ ]*[@](\w+)[ ]+(.*)#mi', 
                function($matches){
                    $matches[1] = ucfirst($matches[1]);
                    return "   - **{$matches[1]}:** {$matches[2]} ";
                }, 
            $content);
            $char   = count($matches) == 1 ? '=' : '-';
            $string[] = trim($name . "\n" .  str_repeat($char, strlen($name)) . "\n\n" . $content);
        }
        return implode("\n\n", $string);
    }
}
