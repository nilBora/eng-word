<?php

class ValuesObject extends Dispatcher
{
    private $_values;

    public function __construct($data)
    {
        $this->_values = $data;
    }

    protected function get($key)
    {
        if (!$this->has($key)) {
            throw new Exception('Key is noe Exists: ' . $key);
        }

        return $this->_values[$key];
    }

    protected function set($key, $value)
    {
        $this->_values[$key] = $value;
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->_values);
    }
}