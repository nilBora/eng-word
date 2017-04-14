<?php
if (!function_exists('isDev')) {
    function isDev()
    {
        if (
            array_key_exists('devIPs', $GLOBALS) && 
            in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['devIPs'])
        ) {
            return true;
        }
        
        return false;
    }    
}

