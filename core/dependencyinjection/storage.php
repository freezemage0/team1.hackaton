<?php
namespace DependencyInjection;

class Storage
{
    protected $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}