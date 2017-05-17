<?php

class SystemLog
{
    public static $systemTime;
    public static $systemMemory;
    public static $queryLog = [];
    
    public static function getMessage($exp)
    {
        $fileName = self::_getFileLogName($exp);
        $ip = self::getIP();
        $content = date('d-m-Y H:s:i').' IP: '.$ip.' '.$exp->getMessage()."\n";
        $fileName = ROOT_DIR.'logs/'.$fileName.'.log';
        file_put_contents($fileName, $content, FILE_APPEND);

        return true;
    }

    private function _getFileLogName($exp)
    {
        return get_class($exp);
    }

    public static function getIP()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        return $ip;
    }
    
    public static function startRecord()
    {
        static::$systemTime = microtime(true);
        static::$systemMemory = memory_get_usage();
        
        return true;
    }
    
    public static function stopRecord()
    {
        $systemMemory = memory_get_usage() - static::$systemMemory;
        $systemTime = microtime(true) - static::$systemTime;
        $systemMemory = static::convertMemory($systemMemory);
        $queryLog = static::$queryLog;
        
        $controller = Controller::getInstance();
        $config = $controller->getConfigs();
        if (!empty($config['dev']['profiler']) && $config['dev']['profiler']) {
            $profiler = new Profiler();
            $profileMessages = $profiler->getMessages();
        }
       

        ob_start();

        include realpath(__DIR__."/../public/templates/sys_info.phtml");

        $content = ob_get_clean();

        echo $content;
    }
    
    public static function convertMemory($size)
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        $i=floor(log($size, 1024));
        
        return @round($size / pow(1024, $i), 2).' '.$unit[$i];
    }
    
    public static function saveQuery($query)
    {
        array_push(static::$queryLog, $query);
    }
}