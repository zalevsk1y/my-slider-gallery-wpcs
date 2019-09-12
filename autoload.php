<?php

function my_slider_gallery_plugin_autoload($class)
{

    if (strpos($class, MYGALLERY_PLUGIN_NAMESPACE) === false) {
        return;
    }
    $class=str_replace(MYGALLERY_PLUGIN_NAMESPACE.'\\','',$class);
    if(false!==strpos($class,'Trait')){
        $file_name= 'traits' . DIRECTORY_SEPARATOR . str_replace( '_', '-', strtolower( $class ) ) . '.php';
    }else if(false!==strpos($class,'Interface')){
        $file_name= 'interfaces' . DIRECTORY_SEPARATOR . str_replace( '_', '-', strtolower( $class ) ) . '.php';
    }else{
        $file_name= 'classes'.DIRECTORY_SEPARATOR.'class-'. str_replace( '_', '-', strtolower( $class ) ) . '.php';
    }
   
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . $file_name;
    if (file_exists($path)) {
        include $path;
    }
}

spl_autoload_register("my_slider_gallery_plugin_autoload");
