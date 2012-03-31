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
        $directory = $this->toDirectory(get_class($class));
        return $this->toDirectory(get_class($class));
    }
    private function toDirectory($className)
    {
        $file   = str_replace('\\','/',$className).".php";
        foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
            if (file_exists($path = $path . DIRECTORY_SEPARATOR . $file)) {
                return new \DirectoryIterator(dirname($path));
            }
        }
        throw new \Exception("Have no include_path to {$class}");
    }
}