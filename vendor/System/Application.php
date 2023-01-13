<?php
namespace System;
class Application{
    /**
     * container
     * @var array
     */
    private $container = [];
     /**
     * Application Object
     *
     * @var \System\Application
     */
    private static $instance;
    /**
     * Constructor
     * @param /System/File.php
     */
    public function __construct(File $file)
    {
        $this->share('file',$file);
        $this->registerClasses();
        $this->loadHelpers();
        
    }
     /**
     * Get Application Instance
     *
     * @param \System\File $file
     * @return \System\Application
     */
    public static function getInstance($file = null)
    {
        if(is_null(static::$instance))
        {
            static::$instance = new static ($file);
        }
        return static::$instance;
    }
     /**
     * Run The Application
     *
     * @return void
     */
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->call('App\index.php');
        list($controller, $method, $arguments) = $this->route->getProperRoute();
    }
    /**
     * register classes in spl autoload register
     * @return void
     */
    private function registerClasses()
    {
        spl_autoload_register([$this,'load']);
    }
    /**
     * Load class through autoloading
     * @param string $class
     * @return void
     */
    public function load($class)
    {
        if(strpos($class , 'App') === 0)
        {
            //get the class from application folder
            $file = $class.'.php';
        }
        else
        {
            //get the class from vendor folder
            $file = 'vendor/'.$class.'.php';
        }
        if($this->file->exists($file))
        {
            $this->file->call($file);
        }
    }
    /**
     * Get shared value
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if(! $this->isSharing($key))
        {
            if($this->isCoreAlises($key))
            {
                $this->share($key, $this->createNewCoreobject($key));
            }
            else
            {
                die('<b>'.$key . 'Not found in Application container </b>');
            }
        }
        return $this->container[$key];
    }
    /**
     * share the given value: key through application
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function share($key, $value)
    {
        $this->container[$key] = $value;
    }
    /**
     * Get shared value dyanmically
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
    /**
     * Require the given file
     * @param string file
     * @return void
     */
    public function require($file)
    {
         require $file;
    }
    /**
     * load helpers files
     * @return void
     */
    private function loadHelpers()
    {
        $this->file->call('vendor/helpers.php');
    }
    /**
     * determine if the given key is shared through application
     * @param string $key
     * @return boolen
     */
    public function isSharing($key)
    {
        return isset($this->container[$key]);
    }
    /**
     * Get all core classes with its iliasses
     * @return array
     */
    private function coreClasses()
    {
        return [
            'request'       => 'System\\Http\\Request',
            'response'      => 'System\\Http\\Response',
            'session'       => 'System\\Session',
            'route'         => 'System\\Route',
            'cookie'        => 'System\\Cookie',
            'load'          => 'System\\Loader',
            'html'          => 'System\\Html',
            'db'            => 'System\\Database',
            'view'          => 'System\\View\\ViewFactory',
            'url'           => 'System\\Url',
            'validator'     => 'System\\Validation',
            'pagination'    => 'System\\Pagination',
       ];
    }
    /**
     * check if class is in coreclasses container
     * @return boolen
     */
    private function isCoreAlises($aliases)
    {
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$aliases]);
    }
    /**
     * Create new object for the core class based on the given alises
     * @param string $alises
     * @return $object
     */
    private function createNewCoreObject($alises)
    {
        $coreClasses = $this->coreClasses();
        $object = $coreClasses[$alises];
        return new $object($this);
    }
}