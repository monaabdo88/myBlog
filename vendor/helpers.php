<?php 
if(! function_exists('pre')){
    /**
     * visualize the given variable in the broswer
     * @param mixed @var
     * @return void
     */
    function pre($var){
        echo '<pre>'.print_r($var).'</pre>';
    }
}
if(! function_exists('array_get'))
{
    function array_get($array , $key , $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}