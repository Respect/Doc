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
    public function get($target) {
        if (is_object($target)) {
            return $this->toDirectory(get_class($target).".php");
        }
        return $this->toDirectory($target);
    }
    private function toDirectory($target)
    {
        $file   = str_replace('\\','/',$target);
        foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
            if (file_exists($path = $path . DIRECTORY_SEPARATOR . $file)) {
                return new \DirectoryIterator(dirname($path));
            }
        }
        throw new Exception("Have no include_path to {$target}");
    }
}