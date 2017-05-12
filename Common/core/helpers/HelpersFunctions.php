<?php
if (!function_exists('isDev')) {
    function isDev()
    {
        if (
            array_key_exists('dev', $GLOBALS) && 
            in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['dev']['IPs'])
        ) {
            return true;
        }
        
        return false;
    }    
}

