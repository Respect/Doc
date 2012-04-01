<?php
namespace Respect\Doc;


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
    private $path;
    private $mode;
    const DOCNS     = 0;
    const DOCCLASS  = 1;
    /** Receives the namespace or class to be documented */
    public function __construct($classOrNamespace, $documentAs = \Self::DOCCLASS)
    {
        $this->mode = $documentAs;
        $this->path = $classOrNamespace;
    }

    /** Returns the documentation in markdown */
    public function __toString()
    {
        $markdown = new MarkDown();
        $contents = "";
        if ($this->mode == Doc::DOCCLASS){
            $content = $this->getContents($this->path);
            $contents = $markdown->get($content);
        } else {
            $nameSpaceAnalizer  = new NameSpaceAnalizer();
            $itens              = $nameSpaceAnalizer->get($this->path);
            while ($itens->valid()) {
                if (!$itens->isDir()) {
                    $classpath = str_replace('.php','',"\\".$this->path."\\".$itens->getFilename());
                    $contents.= $markdown->get( $this->getContents($classpath)).PHP_EOL.PHP_EOL;
                }
                $itens->next();
            }
        }
        return $contents;
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
            $sections = array_merge($sections,$docItem->getClassContent());
        }
        return $sections;
    }
}
