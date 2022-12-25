<?php
namespace System;
class File{
    /**
     * Directory seprator
     * @const string
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Root path
     * @var string
     */
    private $root;
    /**
     * Constructor
     * @param string root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }
    /**
     * Generate full path to the given path in vendor
     * @param string $path
     * @return string path
     */
    public function toVendor($path)
    {
        return $this->to('vendor/'.$path);
    }
    /**
     * Generate full path to the given path
     * @param mixed $path
     * @return string
     */
    public function to($path)
    {
        return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
    }
}