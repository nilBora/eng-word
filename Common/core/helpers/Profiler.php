<?php

class Profiler
{
    private $_dir;
    public function __construct($dir)
    {
        $this->_dir = $dir;
        $this->_start();
    }

    private function _start()
    {

    }

    public function getMessages()
    {
        $file = $this->_dir.'Common/modules/User/User.php';
        $messages = [];
        if (strstr(file_get_contents($file), '$_POST')) {
            $messages[] = 'User Reuqest Class in '.$file;
        }

        return $messages;
    }

}