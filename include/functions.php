<?php

function include_all_classes(string $path) {

    $Directory = new \RecursiveDirectoryIterator($path);
    $Iterator = new \RecursiveIteratorIterator($Directory);
    $Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
    
    foreach ($Regex as $path=>$match) {
        if (
            stripos($path, 'test') !== FALSE || 
            strpos($path,'/bin/')!==FALSE || 
            strpos($path,'soap')!==FALSE || 
            strpos($path,'compatibility')!==FALSE || 
            strpos($path,'Null.php')!==FALSE || 
            strpos($path,'Int.php')!==FALSE ||
            strpos($path,'Object.php')!==FALSE ||
            strpos($path,'Float.php')!==FALSE ||
            strpos($path,'build_phar')!==FALSE ||
            strpos($path,'psalm-autoload.php')!==FALSE ||
            strpos($path,'generate.php')!==FALSE ||
            strpos($path,'.phpstorm.meta.php')!==FALSE ||
            strpos($path,'phar-io')!==FALSE
            ) {
            continue;
        }
        require_once($path);
    }
    
}

function include_random_classes(int $number_of_classes) {
    $available_classes = require_once('../include/available_classes.php');
    //print_r($available_classes);
    $available_classes = array_values($available_classes);
    for ($aa=0 ; $aa < $number_of_classes ; $aa++) {
        $r = rand(0, count($available_classes) - 1);
        $class_name = $available_classes[$r];
        class_exists($class_name);
        //new ReflectionClass($class_name);
    }
}

function get_all_files(string $path) : array
{
    $Directory = new \RecursiveDirectoryIterator($path);
    $Iterator = new \RecursiveIteratorIterator($Directory);
    $Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
    return array_keys(iterator_to_array($Regex));
}