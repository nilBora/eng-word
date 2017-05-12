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
            ],
            'find' => ['$_POST', '$_GET', '$_REQUUEST']
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
        $finds = $this->_config['find'];
        //$messages = [];
        $patern = '##Umis';
        if ($handle = opendir($scanDir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                
                $pathFile = realpath($scanDir.'/'.$file);
                
                if (is_file($pathFile)) {
                    foreach ($finds as $find) {
                        if ($lines = $this->_searchLine($pathFile, $find)) {
                            $messages[] = $this->_fetchMessage($find, $pathFile, $lines);
                        }
                    }
                    
                } else if(is_dir($pathFile)) {
                   $messages = $this->_scanDir($pathFile, $messages); 
                }
            }
            closedir($handle); 
        }
      
        return $messages;
    }
    
    private function _searchLine($filename, $s) 
    { 
        $line = []; 
    
        $fh = fopen($filename, 'rb'); 
    
        for($i = 1; ($t = fgets($fh)) !== false; $i++) { 
            if(strpos($t, $s) !== false) { 
                $line[] = $i;
            } 
        } 
    
        fclose($fh); 
    
        return $line; 
    }
    
    private function _fetchMessage($find, $pathFile, $lines)
    {
         $msg = 'Use Reuqest Class. Find: '.$find.".<br>Line: ".
                                implode(', ', $lines).
                                '. <br>File: '.basename($pathFile).
                                '. <br>Path: '.$pathFile;
        return $msg;
    }

}