<?php

class System
{
    public static function showException($exp)
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $exp->getMessage()]);
        exit;
    }
}