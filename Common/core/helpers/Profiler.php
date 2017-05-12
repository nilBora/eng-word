<?php

class Profiler
{
    private $_config;
    public function __construct($config = false)
    {
        if (!$config) {
            $this->_config = $this->_getDefaultCofig();
        } else {
            $this->_config = $config;    
        }
       
        $this->_start();
    }
    
    private function _getDefaultCofig()
    {
        $config = [
            'scanDir' => [
                MODULES_DIR,
            ]
        ];
        
        return $config;
    }
    
    private function _start()
    {

    }
    
    public function getMessages()
    {
        if (!array_key_exists('scanDir', $this->_config)) {
            return false;
        }
        $messages = [];
        foreach ($this->_config['scanDir'] as $scanDir) {
            $messages = $this->_scanDir($scanDir, $messages);
           
        }
        //print_r($messages);
        //$file = $this->_dir.'Common/modules/User/User.php';
        
        return $messages;
    }
    
    private function _scanDir($scanDir, $messages)
    {
        
        //$messages = [];
        $patern = '##Umis';
        if ($handle = opendir($scanDir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                
                $pathFile = realpath($scanDir.'/'.$file);
                
                if (is_file($pathFile)) {
                    if (strstr(file_get_contents($pathFile), '$_POST')) {
                        $messages[] = 'User Reuqest Class in '.$file;
                    }
                  
                } else if(is_dir($pathFile)) {
                   $messages = $this->_scanDir($pathFile, $messages); 
                }
            }
            closedir($handle); 
        }
      
        return $messages;
    }

}