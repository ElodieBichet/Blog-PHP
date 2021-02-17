<?php

class Renderer
{
    public static function render(string $type, string $path, array $variables =[]) {
        extract($variables);
        ob_start();
        require('templates/' . $type . '/' . $path . '.html.php');
        $pageContent = ob_get_clean();
    
        require('templates/layout.html.php');
    }
}
