<?php

namespace Respect\Doc;


class NameSpaceAnalizer
{
    
/**
 * undocumented function
 *
 * @return void
 * @author Ivo Nascimento
 **/
    public function get($class) {
        //if (is_object($class)) {
            $directory = $this->toDirectory(get_class($class).".php");
        //}
        
        return $directory;
    }
    private function toDirectory($className)
    {
        $file   = str_replace('\\','/',$className);
        foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
            if (file_exists($path = $path . DIRECTORY_SEPARATOR . $file)) {
                return new \DirectoryIterator(dirname($path));
            }
        }
        throw new Exception("Have no include_path to {$className}");
    }
}