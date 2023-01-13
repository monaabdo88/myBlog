<?php
namespace System;
class Cookie{
    /**
     * Application Object
     * @var System\Application
     */
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->path = dirname($this->app->request->server('SCRIPT_NAME')) ? :'/';
    }
     /**
     * Set New Value to cookie
     *
     * @param string $key
     * @param mixed $value
     * @param int $houres
     * @return void
     */
    public function set($key , $value , $houres = 1800)
    {
        $expireTime = $houres == -1 ? -1 : time() + $houres * 360;
        setcookie($key , $value , $expireTime , $this->path,'', false, true); 
    }
    /**
     * Get Value from cookie by the given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key , $default = null)
    {
        return array_get($_COOKIE, $key, $default);
    }
     /**
     * Determine if the cookie has the given key
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key,$_COOKIE);
    }
    /**
     * Remove the given key from cookie
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        $this->set($key , null , -1);
        unset($_COOKIE[$key]);
    }
     /**
     * Get all cookie data
     *
     * @return array
     */
    public function all()
    {
        return $_COOKIE;
    }

     /**
     * Destroy cookie
     *
     * @return void
     */
    public function destroy()
    {
        foreach(array_keys($this->all()) as $key)
        {
            $this->remove($key);
        }

        unset($_COOKIE);
    }
}