<?php
namespace Respect\Doc;

/**
 * speak Markdownish 
 * 
 * @author Ivo Nascimento <ivonascimento@php.net> 
 */
class MarkDown
{
    public function get(array $sections)
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
